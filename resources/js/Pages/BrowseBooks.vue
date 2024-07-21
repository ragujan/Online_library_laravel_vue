<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';
import { BookData, BookGenre } from '@/types';
import PaginationButton from '@/Components/PaginationButtonSection.vue';
import { computed, ref, watch } from 'vue';

const props = defineProps<{ data: BookData[], book_genres: BookGenre[], total_pages: number, page_number: number }>();
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
const selectedGenre = ref("")
const successMessage = ref("");
const showSuccessMessage = ref(false);
const paginateFunction = (index: number) => {

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
        search_genre?: string,
        page?: number,
    } = {};
    if (searchBy.value === "title" && searchText.value != "") {
        objectToSent.search_title = searchText.value
    }
    if (searchBy.value === "description" && searchText.value != "") {
        objectToSent.search_description = searchText.value
    }
    if (selectedGenre.value != "") {
        objectToSent.search_genre = selectedGenre.value
    }
    objectToSent.page = pageNumber;
    router.get(route("browseBooks"), objectToSent);
}
const clearSearchText = () => {
    router.get(route("browseBooks"));
}
// check if the url has no parameters
const isSearchClear = computed(() => {
    let pageUrl = window.location.href.toString();
    const parsedUrl = new URL(pageUrl);
    if (!parsedUrl.search && !parsedUrl.hash) {
        return true;
    } else {
        return false;
    }
})
interface SuccessMessageType {
    message: {
        message_id: string;
        success: string;
    };
}
const borrowBook = (bookId: string) => {
    // alert("hey")
    // return;
    const objectToSent = {
        book_id: bookId
    };
    router.post(route("borrowBook"), objectToSent);
}
const page = usePage()
const message = computed(() => {
    if (page.props.flash) {
        const flash = page.props.flash as SuccessMessageType;
        if (flash.message && flash.message["message_id"] === "user_borrowed_book_success") {
            successMessage.value = flash.message["message_id"]
            showSuccessMessage.value = true;
        }
    }
});
watch(page, () => {
    console.log(page.props.flash)
    if (page.props.flash) {
        const flash = page.props.flash as SuccessMessageType;
        if (flash.message && flash.message["message_id"] === "user_borrowed_book_success" && flash.message["success"]) {
            successMessage.value = flash.message["success"];
            showSuccessMessage.value = true;
        }
    }
})

const clearSuccessMessage = () => {
    successMessage.value = "";
    showSuccessMessage.value = false;
}
const user = computed(() => page.props.auth.user)
</script>

<template>
    <!-- container -->
    <div class="flex flex-col min-h-screen bg-gray-100 gap-y-2 gap-x-2 text-mainTheme">
        <!-- navbar -->
        <div class="flex flex-row items-center justify-between px-3 py-2 font-bold text-white gap-x-5 bg-secondaryTheme">

            <div class="flex flex-row justify-start px-3 font-bold text-white gap-x-5 bg-secondaryTheme">
                <a :href="route('browseBooks')">Browse Books</a>
                <a :href="route('retrieveBorrowedBooks')">My Books</a>
                <span @click="logout" class="cursor-pointer">Log out</span>
            </div>

            <div v-if="user">
                <span>{{ user.name }}</span>
            </div>
        </div>

        <div class="p-4">
            <div v-if="showSuccessMessage"
                class="absolute top-0 left-0 flex flex-col items-center justify-center w-full min-h-screen bg-transparent backdrop-blur-sm">
                <div class="text-2xl">
                    {{ successMessage }}
                </div>
                <button class="px-3 py-2 mt-2 text-white rounded-md bg-secondaryTheme"
                    @click="clearSuccessMessage">Clear</button>
            </div>
            <h1 class="text-xl font-bold">Browse Books</h1>
            <div class="flex flex-col items-center p-3 bg-white rounded-md gap-y-3 md:flex-row md:gap-x-6">
                <div class="flex flex-row items-center md:flex-row gap-x-2">
                    <span>Search By</span>
                    <select class="rounded-md shadow-sm border-mainTheme" v-model="searchBy">
                        <option value="title">Title</option>
                        <option value="description">Description</option>
                        <option value="genre">genre</option>
                    </select>
                </div>
                <select v-if="searchBy === 'genre'" class="rounded-md shadow-sm border-mainTheme" v-model="selectedGenre">
                    <option value="">None</option>
                    <option v-for="genre in book_genres" :key="genre.id" :value="genre.name">
                        {{ genre.name }}
                    </option>
                </select>
                <input v-else class="rounded-md shadow-sm border-mainTheme" v-model="searchText" type="text">
                <button class="px-3 py-2 font-bold text-white rounded-md bg-secondaryTheme"
                    @click="searchBook">Search</button>

                <button class="px-3 py-2 font-bold underline rounded-md " v-if="!isSearchClear"
                    @click="clearSearchText">clear</button>
            </div>
            <div class="flex flex-col items-center p-3 bg-white rounded-md md:flex-row md:gap-x-6">
                <span class="font-thin">
                    Select Book Genre
                </span>

            </div>
            <!-- table to display the book details -->
            <div v-if="data" class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg">
                    <thead class="border-b border-mainTheme">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Title</th>
                            <th class="p-4 text-left">Description</th>
                            <th class="p-4 text-left">Genre</th>
                            <th class="p-4 text-left">Price</th>
                            <th class="p-4 text-left">Borrow</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b " v-for="book in data" :key="book.id">
                            <td class="p-4 text-left">{{ book.id }}</td>
                            <td class="p-4 text-left">{{ book.title }}</td>
                            <td class="p-4 text-left">{{ book.description }}</td>
                            <td class="p-4 text-left">{{ book.book_genre }}</td>
                            <td class="p-4 text-left">{{ book.price }}</td>
                            <td class="p-4 text-left"><button
                                    class="px-1 py-1 rounded-md cursor-pointer bg-lightTheme text-mainTheme"
                                    @click="borrowBook(book.id)">Borrow</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center">
                <PaginationButton :itemsPerPage="3" :lastPage="props.total_pages" :onClickFunction="paginateFunction"
                    :currentPage="Number(props.page_number)" />
            </div>
        </div>
    </div>
</template>