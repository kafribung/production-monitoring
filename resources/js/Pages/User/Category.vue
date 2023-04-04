
<script setup>
// Inertia
import { Head, Link } from "@inertiajs/inertia-vue3";
import NProgress from 'nprogress'

// Component
import Navbar from "@/Components/Navbar.vue";
import Currency from "@/Components/Currency.vue";
import Footer from "@/Components/Footer.vue";

// Setter
const url_img = location.origin + '/storage/'

// Props
const props = defineProps({
    products: Object,
    category: Object,
})

// NProgress
NProgress.start();
NProgress.done()
</script>

<template>
    <!-- Head -->

    <Head :title="'Produk' + category.name" />

    <!-- Navbar -->
    <Navbar />

    <!-- Header Sections -->
    <div class="relative bg-indigo-800">
        <div class="absolute inset-0">
            <img class="h-full w-full object-cover"
                src="https://images.unsplash.com/photo-1525130413817-d45c1d127c42?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1920&q=60&&sat=-100"
                alt="" />
            <div class="absolute inset-0 bg-indigo-800 mix-blend-multiply" aria-hidden="true" />
        </div>
        <div class="relative mx-auto max-w-7xl py-24 px-6 sm:py-32 lg:px-8">
            <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">Get in touch</h1>
            <p class="mt-6 max-w-3xl text-xl text-indigo-100">Mattis amet hendrerit dolor, quisque lorem pharetra.
                Pellentesque lacus nisi urna, arcu sociis eu. Orci vel lectus nisl eget eget ut consectetur. Sit
                justo viverra non adipisicing elit distinctio.</p>
        </div>
    </div>

    <!-- Product List -->
    <div class="bg-white">
        <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div v-if="products.length">
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
            <h2 v-else h2 class="text-2xl font-bold tracking-tight text-gray-900 text-center">Produk tidak ditemukan</h2>
        </div>

    </div>

    <!-- Footer -->
    <Footer />
</template>


