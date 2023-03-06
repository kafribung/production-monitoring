
<script setup>
// Imertia
import { Head, Link } from "@inertiajs/inertia-vue3";
import NProgress from 'nprogress'

// Component
import HeroSection from "@/Components/HeroSection.vue";
import Currency from "@/Components/Currency.vue";
import Footer from "@/Components/Footer.vue";

// Setter
const url_img = location.origin + '/storage/'

// Props
defineProps({ products: Object })

// NProgress
NProgress.start()
NProgress.done()
</script>

<template>
    <!-- Head -->

    <Head title="Home" />

    <!-- Herosection -->
    <HeroSection />

    <!-- Header Sections -->
    <div class="bg-gray-800">
        <div class="mx-auto max-w-7xl py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-lg font-semibold text-white">Pricing</h2>
                <p class="mt-1 text-4xl font-bold tracking-tight text-gray-400 sm:text-5xl lg:text-6xl">Take control of
                    your team.</p>
                <p class="mx-auto mt-5 max-w-xl text-xl text-gray-500">Start building for free, then add a site plan to
                    go live. Account plans unlock additional features.</p>
            </div>
        </div>
    </div>

    <!-- Product List -->
    <div class="bg-white">
        <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Customers also purchased</h2>
            <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div v-for="product in products" :key="product.id" class="group relative">
                    <div
                        class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-80">
                        <img :src="url_img + product.oldest_image.name" :alt="product.oldest_image.name"
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700">
                                <Link :href="route('detail.index', product)">
                                <span aria-hidden="true" class="absolute inset-0" />
                                {{ product.name }}
                                </Link>
                            </h3>
                        </div>
                        <p class="text-sm font-medium text-gray-900">
                            <Currency :price="product.price" />
                        </p>
                    </div>
                    <ul role="list" class="flex items-center justify-start space-x-3 pt-6">
                        <li v-for="color in product.colors" :key="color.id"
                            class="h-4 w-4 rounded-full border border-black border-opacity-10"
                            :style="{ backgroundColor: color.hexa }">
                            <span class="sr-only"> {{ color.name }} {{ color.hexa }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <Footer />
</template>


