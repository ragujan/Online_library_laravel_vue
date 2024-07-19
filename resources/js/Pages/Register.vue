<script setup>
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import Label from '@/Components/Label.vue';
import CustomInput from '@/Components/CustomInput.vue'
import { useForm } from '@inertiajs/vue3';
import eyeIcon from '@/assets/eye_icon.png';
import logo from '@/assets/logo.png';
const count = ref(0);
function increment() {
    count.value++;
}
const form = useForm({
    name: '',
    email: '',
    password: '',
    confirm_password: ''
})
const passwordVisible = ref(false);
const confirmPasswordVisible = ref(false);
const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value
}
const toggleConfirmPasswordVisibility = () => {
    confirmPasswordVisible.value = !confirmPasswordVisible.value;
}
</script>
<template>
    <!-- main container  -->
    <div class="flex flex-col justify-center h-screen bg-gray-100">
        <div class="flex flex-row justify-center py-3">
           <img :src="logo" class="w-[250px] cursor-pointer"lt="">
        </div>
        <section class="flex flex-col px-6 py-3 mx-auto bg-white rounded-md gap-y-3 md:w-1/2">
            <h2 class="pt-2 text-xl font-bold">User Registration</h2>
            <form class="" action="">
                <div class="flex flex-col">
                    <Label value="Email" for="email" />
                    <CustomInput v-model="form.email" id="email" required autofocus autocomplete="email" />
                </div>
                <div class="flex flex-col">
                    <Label value="Name" for="name" />
                    <CustomInput v-model="form.name" id="name" required autofocus autocomplete="name" />
                </div>
                <!-- to display password and the hide option -->
                <div class="relative flex items-center justify-between">
                    <div class="flex flex-col w-full">
                        <Label value="Password" for="password" />
                        <CustomInput v-model="form.password" :type="passwordVisible ? 'text' : 'password'" id="password"
                            required autocomplete="new-password" />
                    </div>
                    <div class="absolute  right-2 top-[60%] z-30 cursor-pointer">
                        <img class="w-[33px]" @click="togglePasswordVisibility" :src="eyeIcon">
                    </div>
                </div>
                <div class="relative flex items-center justify-between">
                    <div class="flex flex-col w-full">
                        <Label value="Confirm password" for="confirm-password" />
                        <CustomInput v-model="form.confirmPassword" :type="confirmPasswordVisible ? 'text' : 'password'"
                            id="confirm-password" required autocomplete="new-password" />
                    </div>
                    <div class="absolute  right-2 top-[60%] z-30 cursor-pointer">
                        <img class="w-[33px]" click="toggleConfirmPasswordVisibility" :src="eyeIcon" />
                    </div>
                </div>

                <div class="flex flex-row items-center justify-end w-full mt-3 gap-x-4">
                    <a href="" class="underline cursor-pointer">or Login</a>
                    <button class="p-2 my-3 text-white rounded-md bg-mainTheme"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </button>
                </div>
            </form>
        </section>
    </div>
</template>