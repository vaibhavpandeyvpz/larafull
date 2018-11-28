<template>
    <div>
        <div class="card-body">
            <button class="btn btn-primary" @click="onCreateClick">Create</button>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="bg-dark text-white">
                <tr>
                    <th>Client ID</th>
                    <th>Name</th>
                    <th>Secret</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="clients.length > 0">
                <tr v-for="client in clients">
                    <td>{{ client.id }}</td>
                    <td>{{ client.name }}</td>
                    <td><code>{{ client.secret }}</code></td>
                    <td>{{ client.created_at }}</td>
                    <td>{{ client.updated_at }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" tabindex="-1" @click="onEditClick(client)">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="onDeleteClick(client)">Delete</button>
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td class="text-muted text-center" colspan="6">You have not created any OAuth clients.</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="modal" id="modal-clients-create" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="forms.create.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <ol><li v-for="error in forms.create.errors">{{ error }}</li></ol>
                        </div>
                        <form role="form">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="clients-create-name">Name</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="clients-create-name" @keyup.enter="store" v-model="forms.create.name">
                                    <small class="form-text text-muted">Something your users will recognize &amp; trust.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="clients-create-redirect">Redirect URL</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="clients-create-redirect" name="redirect" @keyup.enter="store" v-model="forms.create.redirect">
                                    <small class="form-text text-muted">Your application&apos;s authorization callback URL.</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" @click="store">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modal-clients-edit" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="forms.edit.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <ol><li v-for="error in forms.edit.errors">{{ error }}</li></ol>
                        </div>
                        <form role="form">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="clients-edit-name">Name</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="clients-edit-name" @keyup.enter="update" v-model="forms.edit.name">
                                    <small class="form-text text-muted">Something your users will recognize &amp; trust.</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="clients-edit-redirect">Redirect URL</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="clients-edit-redirect" name="redirect" @keyup.enter="update" v-model="forms.edit.redirect">
                                    <small class="form-text text-muted">Your application&apos;s authorization callback URL.</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" @click="update">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .table-responsive .table thead th,
    .table-responsive .table tbody td {
        white-space: nowrap;
    }
</style>

<script>
    const form = () => ({
        errors: [],
        name: null,
        redirect: null,
    });

    export default {
        data() {
            return {
                clients: [],
                forms: {
                    create: form(),
                    edit: form(),
                }
            }
        },
        methods: {
            index() {
                axios.get('/oauth/clients')
                    .then(response => this.clients = response.data)
            },
            onCreateClick() {
                $('#modal-clients-create').modal('show')
            },
            onDeleteClick(client) {
                axios.delete('/oauth/clients/' + client.id)
                    .then(this.index)
            },
            onEditClick(client) {
                this.forms.edit.id = client.id;
                this.forms.edit.name = client.name;
                this.forms.edit.redirect = client.redirect;
                $('#modal-clients-edit').modal('show')
            },
            store() {
                this.save('post', '/oauth/clients', this.forms.create, '#modal-clients-create')
            },
            update() {
                this.save('put', '/oauth/clients/' + this.forms.edit.id, this.forms.edit, '#modal-clients-edit')
            },
            save(method, uri, data, modal) {
                data.errors = [];
                axios[method](uri, _.pick(data, ['name', 'redirect']))
                    .then(() => {
                        data.name = null;
                        data.redirect = null;
                        data.errors = [];
                        $(modal).modal('hide');
                        this.index()
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            data.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            data.errors = ['Something went wrong. Please try again.'];
                        }
                    })
            },
        },
        mounted() {
            $('#modal-clients-create').on('shown.bs.modal', () => $('#clients-create-name').focus());
            $('#modal-clients-edit').on('shown.bs.modal', () => $('#clients-edit-name').focus());
            this.index()
        },
    }
</script>
