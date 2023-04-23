<script setup>
import { StarIcon } from '@heroicons/vue/20/solid'

// Props
const props = defineProps({
    reviews: Object,
})

</script>

<template>
    <div class="bg-white">
        <div>
            <h2 class="font-bold text-2xl mb-5">Review Produk</h2>

            <div class="-my-10">
                <div v-for="(review, reviewIdx) in reviews" :key="review.id" class="flex space-x-4 text-sm text-gray-500">
                    <div v-for="checkout_cart in review.checkout_carts">

                        <div class="flex-none pt-10">
                            <img class="h-10 w-10 rounded-full inline"
                                :src="`https://ui-avatars.com/api/?name=${checkout_cart.review.user.name}&background=random&bold=true`"
                                :alt="checkout_cart.review.user.name" />
                        </div>
                        <div :class="[reviewIdx === 0 ? '' : 'border-t border-gray-200', 'flex-1 pt-2']">
                            <h3 class="font-medium text-gray-900">{{ checkout_cart.review.user.name }}</h3>
                            <p>
                                <time>{{ checkout_cart.review.created_at
                                }}</time>
                            </p>

                            <div class="mt-4 flex items-center">
                                <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating"
                                    :class="[checkout_cart.review.star > rating ? 'text-yellow-400' : 'text-gray-300', 'h-5 w-5 flex-shrink-0']"
                                    aria-hidden="true" />
                            </div>
                            <p class="sr-only">{{ checkout_cart.review.star }} out of 5 stars</p>

                            <!-- {{ checkout_cart.review }} -->
                            <div class="prose prose-sm mt-4 max-w-none text-gray-500" v-html="checkout_cart.review.value" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


