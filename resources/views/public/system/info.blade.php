<x-layouts::minimal title='Bud | System info'>

    <x-page-container>
            <flux:card class="space-y-6">
                <div class="px-4 sm:px-0">
                    <flux:heading size="lg">System information</flux:heading>
                    <flux:text class="mt-2">Information about the application</flux:text>
                </div>
                <div>
                    <div class="mt-6 border-t border-gray-100 dark:border-white/10">
                        <dl class="divide-y divide-gray-100 dark:divide-white/10">
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">
                                    Application name
                                </dt>
                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                    {{$data['app']}}
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">
                                    Version
                                </dt>
                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                    <span class="font-mono">{{$data['version']}}</span>
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">
                                    Status
                                </dt>
                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                    @switch($data['status'])
                                        @case('Healthy')
                                            <flux:badge color="green">Healthy</flux:badge>
                                            @break
                                        @default
                                            <flux:badge>
                                                {{$data['status']}}
                                            </flux:badge>
                                    @endswitch
                                </dd>
                            </div>
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">
                                    Environment
                                </dt>
                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                    {{$data['environment']}}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </flux:card>
        </x-page-container>
</x-layouts::minimal>
