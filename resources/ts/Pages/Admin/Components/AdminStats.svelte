<script lang="ts">
    import { Icon } from '@/Components'
    import { numberFormatInt } from '@/helpers'

    const title = 'Last 30 days'

    type Stat = {
        title: string
        previous: string
        current: string
        is_increase: boolean
        percentage: number
    }

    const stats: Stat[] = [
        {
            title: 'Total Subscribers',
            previous: numberFormatInt(70946),
            current: numberFormatInt(71897),
            is_increase: true,
            percentage: 12,
        },
        {
            title: 'Avg. Open Rate',
            previous: '56.14%',
            current: '58.16%',
            is_increase: true,
            percentage: 2.02,
        },
        {
            title: 'Avg. Click Rate',
            previous: '28.62%',
            current: '24.57%',
            is_increase: false,
            percentage: 4.05,
        },
    ]
</script>

<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">{title}</h3>
    <dl
        class="mt-5 grid grid-cols-1 rounded-lg bg-white dark:bg-gray-800 overflow-hidden shadow divide-y divide-gray-200 dark:divide-gray-600 md:grid-cols-3 md:divide-y-0 md:divide-x"
    >
        {#each stats as item}
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-base font-normal text-gray-900 dark:text-gray-100">{item.title}</dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-primary-600 dark:text-primary-300">
                        {item.current}
                        <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                            from {item.previous}
                        </span>
                    </div>

                    <div
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium md:mt-2 lg:mt-0"
                        class:bg-green-100={item.is_increase}
                        class:text-green-800={item.is_increase}
                        class:bg-red-100={!item.is_increase}
                        class:text-red-800={!item.is_increase}
                    >
                        {#if item.is_increase}
                            <Icon name="arrow-up" classes="text-green-500 -ml-1 mr-0.5 text-xl" />
                        {:else}
                            <Icon name="arrow-down" classes="text-red-500 -ml-1 mr-0.5 text-xl" />
                        {/if}
                        <span class="sr-only"> {item.is_increase ? 'Increased' : 'Decreased'} by </span>
                        {item.percentage}%
                    </div>
                </dd>
            </div>
        {/each}
    </dl>
</div>
