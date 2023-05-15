
<script setup>
// Inertia
import { Head, useForm } from "@inertiajs/inertia-vue3";
import NProgress from 'nprogress'

// Component
import Navbar from "@/Components/Navbar.vue";
import Currency from "@/Components/Currency.vue";
import Banner from "@/Components/Banner.vue";
import Footer from "@/Components/Footer.vue";
import InputError from '@/Components/InputError.vue';
import ListReview from '@/Components/ListReview.vue';

import { ref } from 'vue'

// Icon
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    RadioGroup,
    RadioGroupLabel,
    RadioGroupOption,
    Tab,
    TabGroup,
    TabList,
    TabPanel,
    TabPanels,
} from '@headlessui/vue'
import { StarIcon } from '@heroicons/vue/20/solid'
import { MinusIcon, PlusIcon } from '@heroicons/vue/24/outline'

// Setter
const url_img = location.origin + '/storage/'

// Props
const props = defineProps({
    product: Object,
})

// State
const form = useForm({
    color_id: null,
    quantity: 1,
    size_id: props.product.sizes[0].id,
    product_id: props.product.id,
    custom_id: null,
    note: null
})

// Submit handler
function submit() {
    form.post(route('cart.store'),
        {
            preserveScroll: true,
            onSuccess: () => form.reset('color_id', 'qunatity', 'custom_id', 'note'),
        }
    )
}


const open = ref(false)

// NProgress
NProgress.start();
NProgress.done()
</script>

<template>
    <!-- Head -->

    <Head :title="`Detail ${product.name}`" />

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

    <!-- Product Overviews -->
    <div class="bg-white">
        <!-- Alert -->
        <div v-if="$page.props.flash.message">
            <Banner :message="$page.props.flash.message" />
        </div>
        <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-8">
                <!-- Image gallery -->
                <TabGroup as="div" class="flex flex-col-reverse">
                    <!-- Image selector -->
                    <div class="mx-auto mt-6 hiddecan w-full max-w-2xl sm:block lg:max-w-none">
                        <TabList class="grid grid-cols-4 gap-6">
                            <Tab v-for="image in product.images" :key="image.id"
                                class="relative flex h-24 cursor-pointer items-center justify-center rounded-md bg-white text-sm font-medium uppercase text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring focus:ring-opacity-50 focus:ring-offset-4"
                                v-slot="{ selected }">
                                <span class="sr-only"> {{ image.name }} </span>
                                <span class="absolute inset-0 overflow-hidden rounded-md">
                                    <img :src="url_img + image.name" :alt="image.name"
                                        class="h-full w-full object-cover object-center" />
                                </span>
                                <span
                                    :class="[selected ? 'ring-indigo-500' : 'ring-transparent', 'pointer-events-none absolute inset-0 rounded-md ring-2 ring-offset-2']"
                                    aria-hidden="true" />
                            </Tab>
                        </TabList>
                    </div>

                    <TabPanels class="aspect-w-1 aspect-h-1 w-auto justify-center">
                        <TabPanel v-for="image in product.images" :key="image.id">
                            <img :src="url_img + image.name" :alt="image.name"
                                class="h-7/12 w-7/12 object-cover object-center sm:rounded-lg" />
                        </TabPanel>
                    </TabPanels>
                </TabGroup>
                <!-- Product info -->
                <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ product.name }}</h1>

                    <div class="mt-3">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl tracking-tight text-gray-900">
                            <Currency :price="product.price" />
                        </p>
                    </div>

                    <!-- Reviews -->
                    <div class="mt-3">
                        <h3 class="sr-only">Reviews</h3>
                        <div class="flex items-center">
                            <div class="flex items-center">
                                <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating"
                                    :class="[5 >= rating ? 'text-indigo-500' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']"
                                    aria-hidden="true" />
                            </div>
                            <p class="sr-only"> 5 out of 5 stars</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="sr-only">Description</h3>
                        <div class="space-y-6 text-base text-gray-700" v-html="product.description" />
                    </div>

                    <form @submit.prevent="submit" class="mt-6">
                        <!-- Colors -->
                        <div>
                            <h3 class="after:content-['*'] after:ml-0.5 after:text-red-500 text-sm text-gray-600">Colors
                            </h3>
                            <RadioGroup v-model="form.color_id" class="mt-2">
                                <RadioGroupLabel class="sr-only"> Choose
                                    a color </RadioGroupLabel>
                                <span class="flex items-center space-x-3">
                                    <RadioGroupOption as="template" v-for="color in product.colors" :key="color.id"
                                        :value="color.id" v-slot="{ active, checked }">
                                        <div
                                            :class="[color.hexa, active && checked ? 'ring ring-offset-1' : '', !active && checked ? 'ring-2' : '', '-m-0.5 relative p-0.5 rounded-full flex items-center justify-center cursor-pointer focus:outline-none']">
                                            <RadioGroupLabel as="span" class="sr-only"> {{ color.name }}
                                            </RadioGroupLabel>
                                            <span aria-hidden="true"
                                                class="h-8 w-8 border border-black border-opacity-10 rounded-full"
                                                :style="{ backgroundColor: color.hexa }" />
                                        </div>
                                    </RadioGroupOption>
                                </span>
                            </RadioGroup>
                        </div>

                        <div class="flex flex-col justify-start">
                            <div class="mt-4 ml-2">
                                <label for="quantity"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 text-sm block mb-1 text-gray-600 ">Quantity</label>
                                <select id="quantity" v-model="form.quantity"
                                    class="rounded-md border min-w-full border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus min-w-full:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    <option v-for="n in 10" :value="n">{{ n }}</option>
                                </select>
                            </div>

                            <div class="mt-4 ml-2">
                                <label for="size"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 text-sm block mb-1 text-gray-600">Size</label>
                                <select id="size" v-model="form.size_id"
                                    class="rounded-md border min-w-full border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                    <option v-for="size in product.sizes" :key="size.id" :value="size.id">{{
                                        size.name
                                    }}</option>
                                </select>
                            </div>

                            <div v-if="product.customs_count">
                                <div class=" mt-4 ml-2">
                                    <label for="custom"
                                        class="after:content-['*'] after:ml-0.5 after:text-red-500 text-sm block mb-1 text-gray-600">Custom</label>
                                    <select id="custom" v-model="form.custom_id"
                                        class="rounded-md border min-w-full border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                        <option v-for="custom in product.customs" :key="custom.id" :value="custom.id">{{
                                            custom.name
                                        }}</option>
                                    </select>
                                </div>

                                <div class="mt-4 ml-2">
                                    <label for="note"
                                        class="after:content-['*'] after:ml-0.5 after:text-red-500 text-sm block mb-1 text-gray-600">Note</label>
                                    <textarea id="note" v-model="form.note"
                                        class="rounded-md border min-w-full border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                            </div>

                        </div>

                        <!-- Error messages -->
                        <InputError class="mt-2" :message="form.errors.color_id" />
                        <InputError class="mt-2" :message="form.errors.qunatity" />
                        <div class="sm:flex-col1 mt-10 flex">
                            <button type="submit" :disabled="form.processing"
                                class="flex max-w-full flex-1 items-center justify-center rounded-md border border-transparent bg-indigo-600 py-3 px-8 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50 sm:w-full">
                                Masukkan Keranjang
                            </button>
                        </div>
                    </form>

                    <section aria-labelledby="details-heading" class="mt-12">
                        <h2 id="details-heading" class="sr-only">Additional details</h2>
                        <div class="divide-y divide-gray-200 border-t">
                            <Disclosure as="div" v-slot="{ open }">
                                <h3>
                                    <DisclosureButton
                                        class="group relative flex w-full items-center justify-between py-6 text-left">
                                        <span
                                            :class="[open ? 'text-indigo-600' : 'text-gray-900', 'text-sm font-medium']">Material</span>
                                        <span class="ml-6 flex items-center">
                                            <PlusIcon v-if="!open"
                                                class="block h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                            <MinusIcon v-else
                                                class="block h-6 w-6 text-indigo-400 group-hover:text-indigo-500"
                                                aria-hidden="true" />
                                        </span>
                                    </DisclosureButton>
                                </h3>
                                <DisclosurePanel as="div" class="prose prose-sm pb-6">
                                    <ul role="list">
                                        <li>{{ product.materil.name }}</li>
                                    </ul>
                                </DisclosurePanel>
                            </Disclosure>
                        </div>
                        <div class="divide-y divide-gray-200 border-t">
                            <Disclosure as="div" v-slot="{ open }">
                                <h3>
                                    <DisclosureButton
                                        class="group relative flex w-full items-center justify-between py-6 text-left">
                                        <span
                                            :class="[open ? 'text-indigo-600' : 'text-gray-900', 'text-sm font-medium']">Stok</span>
                                        <span class="ml-6 flex items-center">
                                            <PlusIcon v-if="!open"
                                                class="block h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                            <MinusIcon v-else
                                                class="block h-6 w-6 text-indigo-400 group-hover:text-indigo-500"
                                                aria-hidden="true" />
                                        </span>
                                    </DisclosureButton>
                                </h3>
                                <DisclosurePanel as="div" class="prose prose-sm pb-6">
                                    <ul role="list">
                                        <li>{{ product.stock_first }}</li>
                                    </ul>
                                </DisclosurePanel>
                            </Disclosure>
                        </div>
                    </section>
                </div>
            </div>
            <!-- Review -->
            <ListReview v-if="props.product.carts.length != 0" :carts="props.product.carts" />
        </div>
    </div>

    <!-- Footer -->
    <Footer />
</template>


