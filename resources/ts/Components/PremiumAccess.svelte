<script lang="ts">
    import type { Testimonial } from '@/types'
    import { inertia, page } from '@inertiajs/svelte'

    const testimonials: Testimonial[] = [
        {
            id: 1,
            names: 'Bee',
            content:
                "Our developers were able to go from 0-90% within a week by using their products. Couldn't be happier!",
            position: 'Entrepreneur',
            company: 'Good Reads',
            is_approved: true,
            created_at: new Date(),
        },
        {
            id: 2,
            names: 'David',
            content:
                'I cannot stess enough how quickly I am able to spin up projects for my clients by using Laravel coupled with a TS-backed svelte! Trully a life-saver!',
            position: 'Software Developer',
            company: 'Freelance',
            is_approved: true,
            created_at: new Date(),
        },
        {
            id: 3,
            names: 'Marverik',
            content: 'I am always looking forward to what next AceLords will release. ',
            position: 'Product Manager',
            company: 'Salomon Tech Tips',
            is_approved: true,
            created_at: new Date(),
        },
    ]
</script>

<div class="bg-primary-50 dark:bg-primary-900 relative overflow-hidden">
    <!-- Decorative background image and gradient -->
    <div aria-hidden="true" class="absolute inset-0">
        <div class="absolute inset-0 max-w-7xl mx-auto overflow-hidden xl:px-8">
            <img
                src="https://tailwindui.com/img/ecommerce-images/home-page-02-sale-full-width.jpg"
                alt=""
                class="w-full h-full object-center object-cover"
            />
        </div>
        <div class="absolute inset-0 bg-primary-50 dark:bg-primary-900 bg-opacity-75 dark:bg-opacity-75" />
        <div
            class="absolute inset-0 bg-gradient-to-t from-primary-50 via-primary-50 dark:from-primary-800 dark:via-primary-900"
        />
    </div>

    <!-- Callout -->
    <section
        aria-labelledby="sale-heading"
        class="relative max-w-7xl mx-auto pt-32 px-4 flex flex-col items-center text-center sm:px-6 lg:px-8"
    >
        <div class="max-w-2xl mx-auto lg:max-w-none">
            <h2 id="sale-heading" class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                Get Lifetime Access to our <br />Premium Version
            </h2>
            <p class="mt-4 max-w-xl mx-auto text-xl text-gray-600 dark:text-primary-100">
                Get access to our premium version of {$page.props.siteName}:
            </p>
            <ul class="text-gray-600 dark:text-primary-200 mt-2">
                <li>Improved SEO management</li>
                <li>Horizon, logs, multi-site domain support</li>
                <li>Forgot password, reset password, 2-FA auth with Google|Github|Facebook</li>
                <li>Admin - Manage users</li>
                <li>Admin - Manage and update .env files straight from the dashboard</li>
                <li>Admin - Manage messages</li>
                <li>Admin - Manage notifications</li>
                <li>Admin - Manage more advances settings</li>
                <li>Users - Manage messages</li>
                <li>Users - Manage notifications</li>
            </ul>
            <a href="https://syntaxlexx.gumroad.com/l/xfqol" use:inertia class="mt-6 inline-block w-full sm:w-auto">
                <img src="/img/gumroad-button.jpg" alt="purchase on gumroad" />
            </a>
        </div>
    </section>

    <!-- Testimonials -->
    <section
        aria-labelledby="testimonial-heading"
        class="relative max-w-7xl mx-auto pt-24 px-4 sm:px-6 lg:pt-32 lg:px-8 pb-12"
    >
        <div class="max-w-2xl mx-auto lg:max-w-none">
            <h2 id="testimonial-heading" class="text-2xl font-extrabold tracking-tight text-gray-900">
                What are people saying?
            </h2>

            <div class="mt-16 space-y-16 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
                {#each testimonials as item}
                    <blockquote class="sm:flex lg:block">
                        <svg
                            width="24"
                            height="18"
                            viewBox="0 0 24 18"
                            xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true"
                            class="flex-shrink-0 text-gray-300 dark:text-primary-600"
                        >
                            <path
                                d="M0 18h8.7v-5.555c-.024-3.906 1.113-6.841 2.892-9.68L6.452 0C3.188 2.644-.026 7.86 0 12.469V18zm12.408 0h8.7v-5.555C21.083 8.539 22.22 5.604 24 2.765L18.859 0c-3.263 2.644-6.476 7.86-6.451 12.469V18z"
                                fill="currentColor"
                            />
                        </svg>
                        <div class="mt-8 sm:mt-0 sm:ml-6 lg:mt-10 lg:ml-0">
                            <p class="text-lg text-gray-600 dark:text-primary-300">
                                {item.content}
                            </p>
                            <cite class="mt-4 block font-semibold not-italic text-gray-900 dark:text-primary-200">
                                {item.names}, {item.country ?? ''}
                            </cite>
                        </div>
                    </blockquote>
                {/each}
            </div>
        </div>
    </section>
</div>
