<script setup>
// Inertia
import { Head, Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import NProgress from 'nprogress'

// Component
import Navbar from "@/Components/Navbar.vue";
import Currency from "@/Components/Currency.vue";
import Banner from "@/Components/Banner.vue";
import InputError from '@/Components/InputError.vue';

// Template
import { ref, reactive, computed } from 'vue'
import { RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { CheckCircleIcon, TrashIcon } from '@heroicons/vue/20/solid'
import { Inertia } from "@inertiajs/inertia";

// Props
const props = defineProps({
    product: String,
    star: Number,
    checkout_cart_id: Number,
    value: String,
})

// State
const form = useForm({
    star: props.star,
    value: props.value,
})

// Function
const submit = () => {
    form.patch(route('review.update', props.checkout_cart_id), {
        preserveScroll: true,
        // onFinish: () => form.reset('password'),
    });
};

// NProgress
NProgress.start();
NProgress.done()
</script>

<template>
    <!-- Head -->

    <Head title="Checkout" />

    <!-- Navbar -->
    <Navbar />

    <div class="bg-gray-50">
        <!-- Alert -->
        <div v-if="$page.props.flash.message">
            <Banner :message="$page.props.flash.message" />
        </div>
        <div class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Review</h2>

            <form @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Review Produk</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Silahkan beri penilaian terhadap produk yang sudah
                            dibeli.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="product" class="block text-sm font-medium leading-6 text-gray-900">Nama
                                    Produk</label>
                                <div class="mt-2">
                                    <input type="product" v-model="props.product" id="product" autocomplete="product"
                                        disabled
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                </div>
                            </div>

                            <div class="col-span-full mt-2">
                                <label for="star"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium leading-6 text-gray-900">Bintang</label>
                                <div class="mt-2">
                                    <select id="star" v-model="form.star" autocomplete="star"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option v-for="n in 5" :value="n">{{ n }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.star" />
                                </div>
                            </div>

                            <div class="col-span-full mt-2">
                                <label for="value"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium leading-6 text-gray-900">Penilaian</label>
                                <div class="mt-2">
                                    <textarea id="value" v-model="form.value" rows="3"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                    <InputError class="mt-2" :message="form.errors.value" />
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">Terima kasih atas penilaian subjektif anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <Link :href="route('checkout.show')" type="a" class="text-sm font-semibold leading-6 text-gray-900">
                    Kembali
                    </Link>
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <button type="submit" :disabled="form.processing"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</template>
