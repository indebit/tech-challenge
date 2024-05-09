<template>
    <div v-if="journals && journals.length > 0">
        <table class="w-full">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="journal in journals" :key="journal.id">
                    <td>{{ formatDate(journal.date) }}</td>
                    <td>{{ journal.description }}</td>
                    <td class="text-right">
                        <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else>
        <p class="text-center">The client has no bookings.</p>
    </div>
</template>

<script>

import axios from 'axios';

export default {
    name: 'JournalList',

    props: ['client'],

    mounted() {
        this.fetchJournals();
    },

    data() {
        return {
            journals: [],
        }
    },

    methods: {
        fetchJournals() {
            axios.get(`/clients/${this.client.id}/journals`)
                .then(response => {
                    this.journals = response.data;
                });
        },

        deleteJournal(journal) {
            axios.delete(`/clients/${this.client.id}/journals/${journal.id}`)
                .then(response => {
                    if (response.data === 'Deleted') {
                        this.journals = this.journals.filter(j => j.id !== journal.id);
                    }
                });
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('en-GB');
        }
    }

}

</script>
