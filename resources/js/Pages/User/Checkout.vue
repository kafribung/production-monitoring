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

// Setter
const url_img = location.origin + '/storage/'

// Props
const props = defineProps({
    provinces: Object,
    districts: Object,
    province_id: Number,
    dest_id: Number,
    costs: Object
})

const province_id = ref(props.province_id);
const dest_id = ref(props.dest_id);

const cost = reactive({
    shipping: null,
})

// Function
function showDistrict(e) {
    Inertia.get(route('checkout.index', { province_id: e.target.value }), {
        preserveScroll: true,
        preserveState: true,
    })
}

function showCost(province_id, e) {
    Inertia.get(route('checkout.index', { province_id: province_id, dest_id: e.target.value }), {
        preserveScroll: true,
        preserveState: true,
    })
}

const total = computed(() => {
    return cost.shipping != null ? cost.shipping + usePage().props.value.carts.sub_total : null
})

const shipping = computed(() => {
    return cost.shipping != null ? cost.shipping : null
})

// State
const form = useForm({
    address: null,
    phone: null,
    province_id: province_id.value,
    district_id: dest_id.value,
    subtotal: usePage().props.value.carts.sub_total,
    shipping: shipping,
    total: total
})

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
            <h2 class="sr-only">Checkout</h2>

            <form @submit.prevent="form.post(route('checkout.store'))"
                class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                <div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Informasi Kontak</h2>

                        <div class="mt-4">
                            <label for="email-address" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1">
                                <input type="email" id="email-address" :value="$page.props.auth.user.email" disabled
                                    autocomplete="email"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Informasi Pengiriman</h2>

                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" :value="$page.props.auth.user.name" disabled
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                </div>
                            </div>

                            <div>
                                <label for="province"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-700">Provinsi</label>
                                <div class="mt-1">
                                    <select id="province" v-model="province_id" v-on:change="showDistrict($event)"
                                        autocomplete="province-name"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option :value="null" disabled>Pilih Provinsi</option>
                                        <option v-for="item in provinces" :key="item.province_id" :value="item.province_id">
                                            {{
                                                item.province
                                            }}
                                        </option>

                                    </select>
                                    <InputError class="mt-2" :message="form.errors.province_id" />

                                </div>
                            </div>

                            <div>
                                <label for="district"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-700">Kabupaten</label>
                                <div class="mt-1">
                                    <select id="district" v-model="dest_id" v-on:change="showCost(province_id, $event)"
                                        autocomplete="province-name"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option :value="null" disabled>Pilih Kabupaten</option>
                                        <option v-for="item in districts" :key="item.city_id" :value="item.city_id">
                                            {{
                                                item.city_name
                                            }}
                                        </option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.district_id" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-700">Alamat
                                    Pengiriman</label>
                                <div class="mt-1">
                                    <textarea name="address" v-model="form.address" id="address"
                                        autocomplete="street-address"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    <InputError class="mt-2" :message="form.errors.address" />
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone"
                                    class="after:content-['*'] after:ml-0.5 after:text-red-500 block text-sm font-medium text-gray-700">Nomor
                                    HP</label>
                                <div class="mt-1">
                                    <input type="tel" v-model="form.phone" maxlength="13" pattern="[+0-9]{12}" id="phone"
                                        autocomplete="tel"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    <InputError class="mt-2" :message="form.errors.phone" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="costs" class="mt-10 border-t border-gray-200 pt-10">
                        <RadioGroup v-model="cost.shipping">
                            <RadioGroupLabel
                                class="after:content-['*'] after:ml-0.5 after:text-red-500 text-lg font-medium text-gray-900">
                                Metode Pengiriman</RadioGroupLabel>
                            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                                <RadioGroupOption v-for="cost in costs[0].costs" as="template" :key="cost.service"
                                    :value="cost.cost[0].value" v-slot="{ checked, active }">
                                    <div
                                        :class="[checked ? 'border-transparent' : 'border-gray-300', active ? 'ring-2 ring-indigo-500' : '', 'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none']">
                                        <span class="flex flex-1">
                                            <span class="flex flex-col">
                                                <RadioGroupLabel as="span" class="block text-sm font-medium text-gray-900">
                                                    {{ costs[0].name }} ({{ cost.service }})
                                                </RadioGroupLabel>
                                                <RadioGroupDescription as="span"
                                                    class="mt-1 flex items-center text-sm text-gray-500">
                                                    {{ cost.description }}
                                                </RadioGroupDescription>
                                                <RadioGroupDescription as="span"
                                                    class="mt-1 flex items-center text-sm text-gray-800">
                                                    Estimasi {{ cost.cost[0].etd }} hari
                                                </RadioGroupDescription>
                                                <RadioGroupDescription as="span"
                                                    class="mt-6 text-sm font-medium text-gray-900">
                                                    <Currency :price="cost.cost[0].value" />
                                                </RadioGroupDescription>
                                            </span>
                                        </span>
                                        <CheckCircleIcon v-if="checked" class="h-5 w-5 text-indigo-600"
                                            aria-hidden="true" />
                                        <span
                                            :class="[active ? 'border' : 'border-2', checked ? 'border-indigo-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-lg']"
                                            aria-hidden="true" />
                                    </div>
                                </RadioGroupOption>
                                <InputError class="mt-2" :message="form.errors.shipping" />
                            </div>
                        </RadioGroup>
                    </div>
                </div>

                <!-- Order summary -->
                <div class="mt-10 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">Detail Pesanan</h2>

                    <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                        <h3 class="sr-only">Items in your cart</h3>
                        <ul role="list" class="divide-y divide-gray-200">
                            <li v-for="(cart, index) in $page.props.carts.cart" :key="index" class="flex py-6 px-4 sm:px-6">
                                <div class="flex-shrink-0">
                                    <img :src="url_img + cart.product.oldest_image.name"
                                        :alt="cart.product.oldest_image.name" class="w-20 rounded-md" />
                                </div>

                                <div class="ml-6 flex flex-1 flex-col">
                                    <div class="flex">
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm">
                                                <Link :href="route('detail.index', cart.product.slug)"
                                                    class="font-medium text-gray-700 hover:text-gray-800">{{
                                                        cart.product.name
                                                    }}</Link>
                                            </h4>
                                            <div :style="{ backgroundColor: cart.color.hexa }"
                                                class="h-5 w-5 rounded-full mt-4">
                                            </div>
                                            <p class="mt-4 text-sm text-gray-500">{{ cart.size.name }}</p>
                                        </div>

                                        <div class="ml-4 flow-root flex-shrink-0">
                                            <Link :href="route('cart.destroy', cart.id)" method="delete" as="button"
                                                type="button"
                                                class="-m-2.5 flex items-center justify-center bg-white p-2.5 text-gray-400 hover:text-gray-500">
                                            <span class="sr-only">Remove</span>
                                            <TrashIcon class="h-5 w-5" aria-hidden="true" />
                                            </Link>
                                        </div>
                                    </div>

                                    <div class="flex flex-1 items-end justify-between pt-2">
                                        <p class="text-sm font-medium text-gray-900">
                                            <Currency :price="cart.price" />
                                        </p>

                                        <p class="ml-4 text-sm font-semibold text-gray-900">
                                            {{ cart.quantity }}
                                        </p>
                                    </div>
                                    <div v-if="cart.custom" class="pt-2">
                                        <p class="text-sm font-bold text-gray-900">
                                            Custom:
                                        </p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ cart.custom.name }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ cart.note }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <dl class="space-y-6 border-t border-gray-200 py-6 px-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Subtotal</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    <Currency :price="$page.props.carts.sub_total" />
                                </dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Pengiriman</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    <Currency :price="cost.shipping" />
                                </dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                <dt class="text-base font-medium">Total</dt>
                                <dd class="text-base font-medium text-gray-900">
                                    <Currency :price="total" />
                                </dd>
                            </div>
                        </dl>

                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <button type="submit"
                                class="w-full rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
