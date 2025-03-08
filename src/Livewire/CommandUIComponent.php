<?php

namespace Zwartpet\CommandUI\Livewire;

use Artisan;
use Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;

class CommandUIComponent extends Component
{
    public ?string $run = null;

    /**
     * @var array<string, array{name: string, description: string, required: bool}>
     */
    public array $options = [];

    /**
     * @var array<string, array{name: string, description: string, required: bool}>
     */
    public array $arguments = [];

    public string $query = '';

    public string $executeOptions = '';

    public string $output = '';

    public function __construct()
    {
        if (config('command-ui.gate')) {
            if (! Gate::has(config('command-ui.gate'))) {
                abort(404, 'Missing gate: command-ui');
            }

            if (! Gate::allows(config('command-ui.gate'))) {
                abort(403);
            }
        }
    }

    public function search(): void
    {
        // NOOP
    }

    public function runCommand(string $commandName): void
    {
        $this->run = $commandName;
        /** @var Command $command */
        $command = collect(Artisan::all())
            ->firstOrFail(function (Command $command) use ($commandName) {
                return $command->getName() === $commandName;
            });

        $this->options = collect($command->getDefinition()->getOptions())
            ->map(function (InputOption $option) {
                return [
                    'name' => $option->getName(),
                    'description' => $option->getDescription(),
                    'required' => $option->isValueRequired(),
                ];
            })
            ->toArray();

        $this->arguments = collect($command->getDefinition()->getArguments())
            ->map(function (InputArgument $option) {
                return [
                    'name' => $option->getName(),
                    'description' => $option->getDescription(),
                    'required' => $option->isRequired(),
                ];
            })
            ->toArray();
    }

    public function execute(): void
    {
        try {
            $output = new BufferedOutput;
            Artisan::call(
                sprintf('%s %s', $this->run, $this->executeOptions),
                outputBuffer: $output
            );

            $this->output = $output->fetch();
        } catch (\Throwable $e) {
            $this->output = $e->getMessage();
        }
    }

    public function cancel(): void
    {
        $this->run = null;
        $this->options = [];
        $this->arguments = [];
        $this->executeOptions = '';
        $this->output = '';
    }

    #[Layout('command-ui::components.layouts.app')]
    public function render(): View|Application|Factory
    {
        $isWhitelist = config('command-ui.commands.filter_list') === 'whitelist';
        /** @var array<string> $whitelist */
        $whitelist = config('command-ui.commands.whitelist');
        /** @var array<string> $blacklist */
        $blacklist = config('command-ui.commands.blacklist');

        /** @var Command[] $commands */
        $commands = collect(Artisan::all())
            ->filter(function (Command $command) use ($isWhitelist, $whitelist, $blacklist) {
                if (! empty($this->query) && ! str_contains($command->getName() ?? '', $this->query)) {
                    return false;
                }

                if ($isWhitelist) {
                    return collect($whitelist)
                        ->some(function (string $item) use ($command) {
                            return str_contains($command->getName() ?? '', $item);
                        });
                }

                return collect($blacklist)
                    ->every(function (string $item) use ($command) {
                        return ! str_contains($command->getName() ?? '', $item);
                    });
            })
            ->sort(fn (Command $a, Command $b) => $a->getName() > $b->getName() ? 1 : -1)
            ->toArray();

        return view('command-ui::livewire.command-ui', [
            'commands' => $commands,
        ]);
    }
}
