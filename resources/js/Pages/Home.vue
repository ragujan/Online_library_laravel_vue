<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { BookData } from '@/types';
import PaginationButton from '@/Components/PaginationButtonSection.vue';
const logout = () => {
    router.post(route("logout"), {

    }, {
        onSuccess: () => {
            router.post(route("login"))
        }
    })
}
const props = defineProps<{ data: BookData[], total_pages: number, page_number: number }>();

const paginateFunction = (index: number) => {
    //   alert("hey "+index)
    // const routeName = "retrieveBooks";

    let pageUrl = window.location.href.toString();

    if (pageUrl.includes("page=")) {
        pageUrl = pageUrl.replace(
            "page=" + props.page_number,
            "page=" + index
        );
        // console.log(pageUrl);
    } else {
        pageUrl = pageUrl.concat("?page=" + index);
    }

    router.get(pageUrl);
}
</script>

<template>
    <h1>Hello This is home</h1>
    <button @click="logout">Logout</button>
    <h1>Total Pages</h1>
    <h2 v-if="total_pages">{{ total_pages }}</h2>
    <h1>Current Page</h1>
    <h2 v-if="page_number">{{ page_number }}</h2>

    <div v-if="data">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Genre</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="book in data" :key="book.id">
                    <td>{{ book.id }}</td>
                    <td>{{ book.title }}</td>
                    <td>{{ book.description }}</td>
                    <td>{{ book.book_genre }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <PaginationButton :itemsPerPage="3" :lastPage="props.total_pages" :onClickFunction="paginateFunction"
        :currentPage="Number(props.page_number)" />
</template>