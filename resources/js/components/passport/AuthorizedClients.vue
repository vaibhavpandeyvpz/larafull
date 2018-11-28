<template>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead class="bg-dark text-white">
            <tr>
                <th>Client</th>
                <th>Scopes</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
            </thead>
            <tbody v-if="tokens.length > 0">
            <tr v-for="token in tokens">
                <td>{{ token.client.name }}</td>
                <td v-if="token.scopes.length > 0">{{ token.scopes.join(', ') }}</td>
                <td class="text-muted" v-else>None</td>
                <td>{{ token.created_at }}</td>
                <td>{{ token.updated_at }}</td>
                <td>
                    <button class="btn btn-danger btn-sm" @click="onDeleteClick(token)">Revoke</button>
                </td>
            </tr>
            </tbody>
            <tbody v-else>
            <tr>
                <td class="text-muted text-center" colspan="6">You have not created authorized any clients.</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
    .table-responsive .table thead th,
    .table-responsive .table tbody td {
        white-space: nowrap;
    }
</style>

<script>
    export default {
        data() {
            return {
                tokens: []
            }
        },
        methods: {
            index() {
                axios.get('/oauth/tokens')
                        .then(response => this.tokens = response.data)
            },
            onDeleteClick(token) {
                axios.delete('/oauth/tokens/' + token.id)
                        .then(this.index)
            },
        },
        mounted() {
            this.index()
        },
    }
</script>
