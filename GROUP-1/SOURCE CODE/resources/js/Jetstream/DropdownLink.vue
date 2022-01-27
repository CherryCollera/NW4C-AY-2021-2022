<template>
    <div>
        <button type="submit" :disabled="disabled"  :class="buttonClasses" v-if="as == 'button'">
            <slot></slot>
        </button>
        
        <a :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition" v-else-if="as =='a'">
            <slot></slot>
        </a>

        <inertia-link :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ['href', 'as', 'disabled'],

        computed: {
            buttonClasses(){
                return this.disabled 
                                    ? "block w-full px-4 py-2 text-sm leading-5 text-gray-700 text-left focus:outline-none focus:bg-gray-100 transition cursor-not-allowed"
                                    : "block w-full px-4 py-2 text-sm leading-5 text-gray-700 text-left hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition"
            }
        }
    }
</script>
