<template>
    <confirmation-modal :show="show">
            <template #title>
                <h2>Remove from cart</h2>
            </template>

            <template #content>
                <p>Are you sure you want to remove from cart?</p>
            </template>

            <template #footer>
                <secondary-button @click="close">
                    Cancel
                </secondary-button>

                <danger-button class="ml-2" @click="removeFromCart" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirm
                </danger-button>
            </template>
        </confirmation-modal>
</template>

<script>

    import ConfirmationModal from '@/Jetstream/ConfirmationModal'
    import SecondaryButton from '@/Jetstream/SecondaryButton'
    import DangerButton from '@/Jetstream/DangerButton'

    export default {

        props: ['show', 'close', 'postID'],
        
        components: {
            ConfirmationModal,
            SecondaryButton,
            DangerButton,
        },

        data(){
            return{
                form: this.$inertia.form({
                    postID: this.postID,
                })
            }
        },

        methods:{
            removeFromCart(){
                this.form.delete(route('cart.destroy', this.postID), {
                preserveScroll: true,
                onSuccess: () => this.close(),
                onError: () => console.log('Cant remove from cart'),
                onFinish: () => this.form.reset(),
            })
            },
        },
        
    }
</script>