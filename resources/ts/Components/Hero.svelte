<script>
    import { page } from '@inertiajs/svelte'
    import { FancyButton, Icon } from '.'
    import SubscribeForm from './SubscribeForm.svelte'
</script>

<div class="pt-8 overflow-hidden sm:pt-12 lg:relative lg:py-48">
    <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl lg:grid lg:grid-cols-2 lg:gap-24">
        <div>
            <div>
                <img class="h-11 w-auto object-contain" src={$page.props.siteLogo} alt={$page.props.siteName} />
            </div>
            <div class="mt-20">
                <div>
                    <a href="/about" class="inline-flex space-x-4">
                        <span
                            class="rounded bg-primary-200 px-2.5 py-1 text-xs font-semibold font-roboto text-primary-500 tracking-wide uppercase"
                        >
                            What's new
                        </span>
                        <span class="inline-flex items-center text-sm font-medium text-primary-500 space-x-1">
                            <span>Just shipped version {$page.props.systemVersion}</span>
                            <!-- Heroicon name: solid/chevron-right -->
                            <svg
                                class="h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </span>
                    </a>
                </div>
                <div class="mt-6 sm:max-w-xl">
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                        Laravel Webpp for Quality Applications
                    </h1>
                    <p class="mt-6 text-xl text-gray-500">
                        We decided to open-source parts of our cash-cow projects, to showcase one way of how a sample
                        small-to-medium sized project is built.
                    </p>
                </div>
                <div class="mt-5">
                    <p class="text-xs mb-3">Subsribe to get the latest updates</p>
                    <SubscribeForm />
                </div>
                <div class="mt-6">
                    <div class="inline-flex items-center divide-x divide-primary-300">
                        <div class="flex-shrink-0 flex pr-5">
                            {#each Array(5).fill(5) as i}
                                <Icon name="star" classes="text-yellow-400" />
                            {/each}
                        </div>
                        <div class="min-w-0 flex-1 pl-5 py-1 text-sm text-gray-500 sm:py-3">
                            <span class="font-medium text-gray-900">Rated 5 stars</span> by over
                            <span class="font-medium text-tertiary-500">20 beta users</span>
                        </div>
                    </div>
                </div>
                <br />
                <div class="w-full flex lg:justify-end lg:pr-10">
                    <a href="https://github.com/SyntaxLexx/laravelte" class="no-underline" target="_blank">
                        <FancyButton size="lg">
                            View on Github
                            <Icon name="link-external" />
                        </FancyButton>
                    </a>
                </div>
                <p class="mt-12 text-xl text-gray-500">
                    This version is currently running on <span class="font-bold"
                        >Laravel v{$page.props.laravelVersion}</span
                    >
                    paired with <span class="font-bold">PHP v{$page.props.phpVersion}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="sm:mx-auto sm:max-w-3xl sm:px-6">
        <div class="py-12 sm:relative sm:mt-12 sm:py-16 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <div class="hidden sm:block">
                <div
                    class="absolute inset-y-0 left-1/2 w-screen bg-primary-100 dark:bg-primary-800 rounded-l-3xl lg:left-80 lg:right-0 lg:w-full"
                />
                <svg
                    class="absolute top-8 right-1/2 -mr-3 lg:m-0 lg:left-0"
                    width="404"
                    height="392"
                    fill="none"
                    viewBox="0 0 404 392"
                >
                    <defs>
                        <pattern
                            id="837c3e70-6c3a-44e6-8854-cc48c737b659"
                            x="0"
                            y="0"
                            width="20"
                            height="20"
                            patternUnits="userSpaceOnUse"
                        >
                            <rect
                                x="0"
                                y="0"
                                width="4"
                                height="4"
                                class="text-primary-400 dark:text-primary-500"
                                fill="currentColor"
                            />
                        </pattern>
                    </defs>
                    <rect width="404" height="392" fill="url(#837c3e70-6c3a-44e6-8854-cc48c737b659)" />
                </svg>
            </div>
            <div class="relative pl-4 -mr-40 sm:mx-auto sm:max-w-3xl sm:px-0 lg:max-w-none lg:h-full lg:pl-12">
                <img
                    class="w-full rounded-md shadow-xl ring-1 ring-black ring-opacity-5 lg:h-full lg:w-auto lg:max-w-none"
                    src="/img/laravelte-dashboard.jpg"
                    alt="dashboard"
                />
            </div>
        </div>
    </div>
</div>
