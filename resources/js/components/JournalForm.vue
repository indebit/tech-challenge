<template>
    <div>
        <h3 class="mb-3">Create new journal</h3>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" class="form-control" v-model="journal.date">
            <p v-if="errors.date" class="mt-2 text-sm text-red-600">{{ errors.date[0] }}</p>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" class="form-control" v-model="journal.description"></textarea>
            <p v-if="errors.description" class="mt-2 text-sm text-red-600">{{ errors.description[0] }}</p>
        </div>

        <div class="text-right">
            <a :href="'/clients/' + client.id" class="btn btn-default">Cancel</a>
            <button @click="storeJournal" class="btn btn-primary">Create</button>
        </div>
    </div>
</template>

<script>
import { error } from 'jquery';


export default {
    name: 'JournalForm',

    props: ['client'],

    data() {
        return {
            journal: {
                date: '',
                description: '',
            },
            errors: {},
        }
    },

    methods: {
        storeJournal() {
            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then((data) => {
                    window.location.href = data.data.url;
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        }
    }

}

</script>
