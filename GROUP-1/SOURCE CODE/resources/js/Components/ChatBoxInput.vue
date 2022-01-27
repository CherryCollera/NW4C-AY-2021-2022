<template>
    <div class="w-full py-3 px-3 flex items-center justify-between border-t border-gray-300">
        <!-- Image Upload Button -->
        <button @click="openAddPhoto" class="outline-none focus:outline-none">
            <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </button>

        <!-- Emoji Button -->
        <dropup style="margin-top:0.35rem;">
            <template #trigger>
                <button class="outline-none focus:outline-none ml-1">
                    <svg class="text-gray-400 h-6 w-6 feather feather-smile" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                </button>
            </template>

            <template #content>
                <picker :data="emojiIndex" @select="showEmoji" />
            </template>
        </dropup>

        <input ref="msg_content" v-model="form.msg_content" @keyup.enter="sendMessage"  type="text" class="w-full py-2 pr-4 text-gray-700 bg-white border border-gray-300 rounded-xl focus:border-green-500 focus:outline-none focus:ring-0" placeholder="Type message here...">
        
        <button class="outline-none focus:outline-none" type="submit" @click="sendMessage" :class="{ 'opacity-25': form.processing }" :disabled="form.processing || isTextboxEmpty()">
            <svg :class="isTextboxEmpty() ? 'text-gray-400 cursor-default' : 'text-green-600'" class="h-7 w-7 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
            </svg>
        </button>
    </div>
</template>

<script>
import Dropup from '@/Components/Dropup'
import data from "emoji-mart-vue-fast/data/all.json";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast/src";
import "emoji-mart-vue-fast/css/emoji-mart.css";

let emojiIndex = new EmojiIndex(data);

export default {

    props:['openAddPhoto', 'convo', 'form'],

    components:{
        Picker,
        Dropup,
    },

    data(){
        return{
            emojiIndex: emojiIndex,
        }
    },

    methods:{

        isTextboxEmpty(){
            return this.form.msg_content === '' ? true : false
        },

        sendMessage() {
            this.form.post(route('message.store'), {
                preserveScroll: true,
                onSuccess: () => this.form.reset(),
                onError: (e) => console.log(e),
                onFinish: () => this.form.reset(),
            })
        },

        showEmoji(emoji) {
            this.form.msg_content = this.form.msg_content + emoji.native;
        },
    },

    mounted(){
        this.$refs.msg_content.focus()
    }
    
}
</script>