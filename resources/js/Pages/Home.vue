<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { BookData } from '@/types';
import PaginationButton from '@/Components/PaginationButtonSection.vue';
import { computed, ref } from 'vue';

const props = defineProps<{ data: BookData[], total_pages: number, page_number: number }>();
const logout = () => {
    router.post(route("logout"), {

    }, {
        onSuccess: () => {
            router.post(route("login"))
        }
    })
}

const searchBy = ref("title");
const searchText = ref("");
const isUrlClean = ref(true);
const paginateFunction = (index: number) => {
    //   alert("hey "+index)
    // const routeName = "retrieveBooks";

    let pageUrl = window.location.href.toString();

    // if page url contains the page paramter replace the value 
    // with the variable index's value
    if (pageUrl.includes("page=")) {
        pageUrl = pageUrl.replace(
            "page=" + props.page_number,
            "page=" + index
        );
    } else {
        // else concatinate the page parameter
        pageUrl = pageUrl.concat("?page=" + index);
    }

    router.get(pageUrl);
}

const searchBook = () => {
    console.log(searchBy.value);
    console.log("search text ")
    console.log(searchText.value)
    // return;
    let pageUrl = window.location.href.toString();
    let pageNumber: number = 1;
    //   processs to get the existing page number
    if (pageUrl.includes("page=")) {
        const match = pageUrl.match(/page=(\d+)/);
        if (match) {
            pageNumber = parseInt(match[1], 10);
        }
    }
    const objectToSent: {
        search_title?: string,
        search_description?: string,
        page?: number,
    } = {};
    if (searchBy.value === "title") {
        objectToSent.search_title = searchText.value
    }
    if (searchBy.value === "description") {
        objectToSent.search_description = searchText.value
    }
    objectToSent.page = pageNumber;
    router.get(route("retrieveBooks"), objectToSent);
}
const clearSearchText = () => {
    router.get(route("retrieveBooks"));
}
const isSearchClear = computed(() => {
    let pageUrl = window.location.href.toString();
    const parsedUrl = new URL(pageUrl);
    if (!parsedUrl.search && !parsedUrl.hash) {
        return true;
    } else {
        return false;
    }
})
</script>

<template>
    <h1>Browse Books</h1>
 

    <div>
        <span>Search By</span>
        <select v-model="searchBy">
            <option value="title">Title</option>
            <option value="description">Description</option>
        </select>
        <input v-model="searchText" type="text">
        <button @click="searchBook">Search</button>

        <button v-if="!isSearchClear" @click="clearSearchText">clear</button>
    </div>
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