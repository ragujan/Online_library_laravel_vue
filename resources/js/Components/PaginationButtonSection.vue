<script setup lang="ts">
import CustomButton from '@/Components/CustomButton.vue';
import { ref } from 'vue';
interface PaginationButtonsProps {
    lastPage: number;
    itemsPerPage: number;
    onClickFunction: (id: number) => void;
    currentPage: number;
}
const props = defineProps<PaginationButtonsProps>();

const pages = ref(Math.ceil(props.lastPage / props.itemsPerPage));
const pagesToNavigateBack = props.itemsPerPage;
const pagesToNavigateForward = props.itemsPerPage;
const handlePrevClick = () => {
    if (props.currentPage === 1 || props.currentPage === 0) {
        return;
    }
    props.onClickFunction(props.currentPage - 1);
}

const handleNextClick = () => {
    if (props.currentPage >= props.lastPage) {
        return;
    }
    console.log("current page "+props.currentPage)
    console.log("pages value "+pages.value)
    props.onClickFunction(props.currentPage + 1);
}

const pagesToNavigateBackArray: () => number[] = () => {
    return Array.from({ length: pagesToNavigateBack }, (_, index) => {
        return props.currentPage - (index + 1);
    }).filter(targetPage => targetPage > 0).reverse();
}

const pagesToNavigateNextArray: () => number[] = () => {
    // return [1,3,4,5,6]
    return Array.from({ length: pagesToNavigateForward }, (_, index) => {
        const targetPage = props.currentPage + (index + 1)
        return props.currentPage + (index + 1);

    }).filter(targetPage => targetPage <= props.lastPage);
}
const higherThanZero: (targetPage: number) => boolean = (targetPage: number) => {
    if (targetPage > 0) {
        return true;
    }
    return false;
}
const showResults = () => {
    console.log(pagesToNavigateNextArray());
}

</script>

<template>
    <!-- container -->
    <div class="flex flex-row gap-x-2">
        <CustomButton class="p-3 m-2 text-white rounded-full bg-mainTheme" :value="'Prev'"
            :onClickFunction="handlePrevClick" />
        <div v-for="(page, index) in pagesToNavigateBackArray()" :key="index">

            <CustomButton class="p-3 m-2 text-white rounded-full bg-mainTheme" :value="page"
                :onClickFunction="() => { onClickFunction(page) }" />
        </div>
        <!-- current page button -->
        <div>
            <CustomButton class="p-3 m-2 text-white rounded-full bg-lightTheme" :value="props.currentPage"
                :onClickFunction="() => { }" />
        </div>
        <div v-for="(page, index) in pagesToNavigateNextArray()" :key="index">

            <CustomButton class="p-3 m-2 text-white rounded-full bg-mainTheme" :value="page"
                :onClickFunction="() => { onClickFunction(page) }" />
        </div>
        <CustomButton class="p-3 m-2 text-white rounded-full bg-mainTheme" :value="'Next'"
            :onClickFunction="handleNextClick" />
    </div>

</template>
