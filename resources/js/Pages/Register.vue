<script setup>
import { ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import Label from '@/Components/Label.vue';
import CustomInput from '@/Components/CustomInput.vue'
import { router, useForm } from '@inertiajs/vue3';
import eyeIcon from '@/assets/eye_icon.png';
import logo from '@/assets/logo.png';
import InputError from '@/Components/InputError.vue';
const count = ref(0);
function increment() {
    count.value++;
}
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})
const passwordVisible = ref(false);
const confirmPasswordVisible = ref(false);
const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value
}
const toggleConfirmPasswordVisibility = () => {
    confirmPasswordVisible.value = !confirmPasswordVisible.value;
}
const submit = () => {
    form.post(route("signup"), {
        onFinish: () => {
            form.reset('password_confirmation', 'password', 'email', 'name')
        }
    })
}
</script>
<template>
    <!-- main container  -->
    <div class="flex flex-col justify-center min-h-screen bg-gray-100">
        <div class="flex flex-row justify-center py-3">
            <img :src="logo" class="w-[250px] cursor-pointer" lt="">
        </div>
        <section class="flex flex-col px-6 py-3 mx-auto bg-white rounded-md text-mainTheme gap-y-3 md:w-1/2">
            <h2 class="pt-2 text-xl font-bold">User Registration</h2>
            <form @submit.prevent="submit">
                <!-- email -->
                <div class="flex flex-col">
                    <Label value="Email" for="email" />
                    <CustomInput v-model="form.email" id="email" required autofocus autocomplete="email" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <!-- name -->
                <div class="flex flex-col">
                    <Label value="Name" for="name" />
                    <CustomInput v-model="form.name" id="name" required autofocus autocomplete="name" />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <!-- to display password and the hide option -->
                <!-- password -->
                <div class="relative flex items-center justify-between">
                    <div class="flex flex-col w-full">
                        <Label value="Password" for="password" />
                        <CustomInput v-model="form.password" :type="passwordVisible ? 'text' : 'password'" id="password"
                            required autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                    <div class="absolute  right-2 top-[60%] z-30 cursor-pointer">
                        <img class="w-[33px]" @click="togglePasswordVisibility" :src="eyeIcon">
                    </div>
                </div>
                <!-- password confirmation -->
                <div class="relative flex items-center justify-between">
                    <div class="flex flex-col w-full">
                        <Label value="Password Confirmation" for="password_confirmation" />
                        <CustomInput v-model="form.password_confirmation" id="password_confirmation"
                            name="password_confirmation" :type="confirmPasswordVisible ? 'text' : 'password'" required
                            autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>
                    <div class="absolute  right-2 top-[60%] z-30 cursor-pointer">
                        <img class="w-[33px]" @click="toggleConfirmPasswordVisibility" :src="eyeIcon" />
                    </div>
                </div>
                <!-- submit button -->
                <div class="flex flex-row items-center justify-end w-full mt-3 gap-x-4">
                    <a href="" class="underline cursor-pointer">or Login</a>
                    <button type="submit" class="p-2 my-3 text-white rounded-md bg-mainTheme"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </button>
                </div>
            </form>
        </section>
    </div>
</template>