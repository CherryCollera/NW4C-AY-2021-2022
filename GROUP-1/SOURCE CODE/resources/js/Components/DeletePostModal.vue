<template>
    <jet-dialog-modal :show="showingDeletePostModal" @close="closeDeletePostModal">
        <template #title>
            Delete Post
        </template>

        <template #content>
            Are you sure you want to delete the post '{{ postData.title }}'? Once it is deleted, it cannot be recovered again. It will be gone forever.
            Enter your password, so we can verify that you want to delete it.
                <div class="mt-4 flex flex-col justify-center">
                    <jet-label for="password" value="Verify Password" />
                    <jet-input type="password" class="mt-1 block w-full" placeholder="Type your password here"
                                id="password"
                                ref="password"
                                v-model="form.password"
                                @keyup.enter="deletePost"
                                required />
                    <jet-input-error :message="form.errors.password" class="mt-2" />
                </div>

        </template>

        <template #footer>
                <jet-secondary-button @click="closeDeletePostModal">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deletePost" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete
                </jet-danger-button>
            </template>
    </jet-dialog-modal>
</template>

<script>

    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetLabel from '@/Jetstream/Label'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {

        components:{
            JetDialogModal,
            JetLabel,
            JetInput,
            JetInputError,
            JetDangerButton,
            JetSecondaryButton,
        },

        props: ['showingDeletePostModal', 'closeDeletePostModal', 'postData'],
        
        data() {
            return {
                form: this.$inertia.form({
                    password: null,
                }),
            }
        },

        methods:{
            
            deletePost() {
                this.form.delete(route('post.destroy', this.postData.id), {
                    preserveScroll: true,
                    onSuccess: () => this.closeDeletePostModal(),
                    onError: () => this.$refs.password.focus(),
                    onFinish: () => this.form.reset(),
                })
            },
        },

        beforeUpdate() {
            setTimeout(() => {
                if(this.$refs.password) this.$refs.password.focus()
            }, 250)
            this.form.reset()
        }
        
    }
</script>