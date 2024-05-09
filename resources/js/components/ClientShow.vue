<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn" :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <div class="flex justify-between">
                        <h3 class="mb-3">List of client bookings</h3>
                        <select class="border border-1 px-2" v-model="bookingsFilter">
                            <option value="all">All Bookings</option>
                            <option value="future">Future bookings only</option>
                            <option value="past">Past bookings only</option>
                        </select>
                    </div>

                    <template v-if="client.bookings && client.bookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in filteredAndSortedBookings" :key="booking.id">
                                    <td>{{ dateTimeRange(booking.start, booking.end) }}</td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">List of client journals</h3>

                    <p>(BONUS) TODO: implement this feature</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            localBookings: [],
            bookingsFilter: 'all',
        }
    },

    mounted() {
        this.localBookings = [...this.client.bookings];
    },

    computed: {
        filteredAndSortedBookings() {
            let filteredBookings = this.localBookings;

            if (this.bookingsFilter == 'future') {
                filteredBookings = this.localBookings.filter(booking => new Date(booking.start) > new Date());
            } else if (this.bookingsFilter == 'past') {
                filteredBookings = this.localBookings.filter(booking => new Date(booking.start) < new Date());
            }

            return filteredBookings.sort((a, b) => new Date(b.start) - new Date(a.start));
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        dateTimeRange(start, end) {
            const dateFormatOptions = {
                year: 'numeric',
                month: 'long',
                day: '2-digit',
                weekday: 'long',
            };

            const timeFormatOptions = {
                hour: '2-digit',
                minute: '2-digit'
            }

            const startDate = new Date(start).toLocaleDateString('en-GB', dateFormatOptions).replace(',', '');
            const startTime = new Date(start).toLocaleTimeString('en-GB', timeFormatOptions);
            const endTime = new Date(end).toLocaleTimeString('en-GB', timeFormatOptions);

            return `${startDate}, ${startTime} to ${endTime}`;
        }
    }
}
</script>
