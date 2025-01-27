<template>
    <h1 class="text-3xl font-bold pb-4 pt-2">Welcome to tech test page.</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <div v-for="country in countries" class="max-w-sm rounded overflow-hidden shadow-lg">
            <img :src="country.flag_url" class="object-cover" :alt="country.name"></img>
            <div class="px-6 py-4">
                <div>{{country.name}}</div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import {onMounted} from "vue";
    import {ref} from 'vue'

    const countries = ref(null);

    const fetchCountries = () => {
        axios.get('/api/countries', {responseType: "json"})
            .then(response => {
                countries.value = response.data;
            }).catch(error => {
                console.log(error)
            })

        }

    onMounted(() => {
        fetchCountries();
    })

</script>

<style>

</style>
