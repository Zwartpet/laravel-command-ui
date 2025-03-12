<div class="text-[13px] leading-[20px] flex-1 p-6 pb-12 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-bl-lg rounded-br-lg lg:rounded-tl-lg lg:rounded-br-none">
    <h1 class="text-2xl">
        @if($run)
            {{ __('command-ui::command-ui.run_command', ['command' => $run])  }}
        @else
            {{ __('command-ui::command-ui.title')  }}
        @endif
    </h1>
    @if($run)
        <form wire:submit="execute">
            <div class="mt-4 flex flex-col gap-4">
                @if(count($options) || count($arguments))
                <div>
                    <h3>{{ __('command-ui::command-ui.form.execute_options') }}</h3>
                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           type="text" wire:model="executeOptions"
                           placeholder="{{ __('command-ui::command-ui.form.execute_options') }}">
                </div>
                @else
                    {{ __('command-ui::command-ui.form.no_execute_options') }}
                @endif
                <div>
                    <button class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal"
                            type="button"
                            wire:click="cancel">
                        {{ __('command-ui::command-ui.actions.cancel') }}
                    </button>
                    <button class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal"
                            type="submit">
                        {{ __('command-ui::command-ui.actions.run') }}
                    </button>
                </div>
            </div>
        </form>

        @if(!empty($output))
            <div class="mt-4">
                <pre class="max-w-xl overflow-scroll bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $output }}</pre>
            </div>
        @endif

        @if(count($arguments))
            <table class="mt-4 w-full text-left table-auto min-w-max">
                <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        {{ __('command-ui::command-ui.arguments.name') }}
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        {{ __('command-ui::command-ui.arguments.description') }}
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        {{ __('command-ui::command-ui.arguments.required') }}
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($arguments as $key => $argument)
                    <tr wire:key="{{ $key }}">
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ $argument['name'] }}
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ $argument['description'] }}
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ $argument['required'] ? __('command-ui::command-ui.yes') : __('command-ui::command-ui.no') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(count($options))
            <table class="mt-4 w-full text-left table-auto min-w-max">
                <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        {{ __('command-ui::command-ui.options.name') }}
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        {{ __('command-ui::command-ui.options.description') }}
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        {{ __('command-ui::command-ui.options.required') }}
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($options as $key => $argument)
                    <tr wire:key="{{ $key }}">
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ $argument['name'] }}
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ $argument['description'] }}
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ $argument['required'] ? __('command-ui::command-ui.yes') : __('command-ui::command-ui.no') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    @else
        <form wire:submit="search" class="flex justify-end gap-4 mt-4">
            <div>
                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       type="text" wire:model="query"
                       placeholder="{{ __('command-ui::command-ui.search') }}">
            </div>

            <button class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal"
                    type="submit">{{ __('command-ui::command-ui.search') }}
            </button>
        </form>

        <table class="w-full text-left table-auto min-w-max">
            <thead>
            <tr>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                    {{ __('command-ui::command-ui.table.command') }}
                </th>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                    {{ __('command-ui::command-ui.table.description') }}
                </th>
                <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                    {{ __('command-ui::command-ui.table.actions') }}
                </th>
            </tr>
            </thead>
            <tbody>

            @foreach($commands as $key => $command)
                <tr wire:key="{{ $command->getName() }}">
                    <td class="p-4 border-b border-blue-gray-50">
                        {{ $command->getName() }}
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        {{ $command->getDescription() }}
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                        <button class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal"
                                wire:click="runCommand('{{ $command->getName() }}')">
                            {{ __('command-ui::command-ui.actions.run') }}
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
