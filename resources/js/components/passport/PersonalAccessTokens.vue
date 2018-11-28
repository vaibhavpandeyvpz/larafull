<template>
    <div>
        <div class="card-body">
            <button class="btn btn-primary" @click="onCreateClick">Create</button>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="bg-dark text-white">
                <tr>
                    <th>Name</th>
                    <th>Scopes</th>
                    <th>Created At</th>
                    <th>Expires At</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="tokens.length > 0">
                <tr v-for="token in tokens">
                    <td>{{ token.name }}</td>
                    <td v-if="token.scopes.length > 0">{{ token.scopes.join(', ') }}</td>
                    <td class="text-muted" v-else>None</td>
                    <td>{{ token.created_at }}</td>
                    <td>{{ token.expires_at }}</td>
                    <td><button class="btn btn-danger btn-sm" @click="onDeleteClick(token)">Revoke</button></td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td class="text-muted text-center" colspan="5">You have not created any personal access tokens.</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="modal" id="modal-tokens-create" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Token</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="form.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <ol><li v-for="error in form.errors">{{ error }}</li></ol>
                        </div>
                        <form role="form">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="tokens-create-name">Name</label>
                                <div class="col-md-9">
                                    <input class="form-control" id="tokens-create-name" @keyup.enter="store" v-model="form.name">
                                    <small class="form-text text-muted">Something you may remember &amp; recognize.</small>
                                </div>
                            </div>
                            <div class="form-group row" v-if="scopes.length > 0">
                                <label class="col-md-3 col-form-label">Scopes</label>
                                <div class="col-md-9">
                                    <div class="checkbox" v-for="scope in scopes">
                                        <label>
                                            <input type="checkbox" @click="setScopeSelected(scope.id)" :checked="isScopeSelected(scope.id)"> {{ scope.description }}
                                        </label>
                                    </div>
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
        <div class="modal" id="modal-tokens-show" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Token Created</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Here is your new personal access token. This is the only time it will be shown so don't lose it!
                            You may now use this token to make API requests.
                        </p>
                        <!--suppress HtmlFormInputWithoutLabel -->
                        <textarea class="form-control" id="tokens-show-token" rows="10" v-model="token"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    export default {
        data() {
            return {
                token: null,
                tokens: [],
                scopes: [],
                form: {
                    name: null,
                    scopes: [],
                    errors: []
                }
            }
        },
        methods: {
            index() {
                axios.get('/oauth/personal-access-tokens')
                    .then(response => this.tokens = response.data);
                axios.get('/oauth/scopes')
                    .then(response => this.scopes = response.data)
            },
            isScopeSelected(scope) {
                return _.indexOf(this.form.scopes, scope) >= 0
            },
            onCreateClick() {
                $('#modal-tokens-create').modal('show')
            },
            onDeleteClick(token) {
                axios.delete('/oauth/personal-access-tokens/' + token.id)
                    .then(this.index)
            },
            setScopeSelected(scope) {
                if (this.isScopeSelected(scope)) {
                    this.form.scopes = _.reject(this.form.scopes, s => s === scope)
                } else {
                    this.form.scopes.push(scope)
                }
            },
            store() {
                this.token = null;
                this.form.errors = [];
                axios.post('/oauth/personal-access-tokens', this.form)
                    .then(response => {
                        this.form.name = '';
                        this.form.scopes = [];
                        this.form.errors = [];
                        this.tokens.push(response.data.token);
                        this.show(response.data.accessToken)
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            this.form.errors = _.flatten(_.toArray(error.response.data.errors))
                        } else {
                            this.form.errors = ['Something went wrong. Please try again.']
                        }
                    })
            },
            show(token) {
                this.token = token;
                $('#modal-tokens-create').modal('hide');
                $('#modal-tokens-show').modal('show')
            },
        },
        mounted() {
            this.index();
            $('#modal-tokens-create').on('shown.bs.modal', () => $('#tokens-create-name').focus());
            $('#modal-tokens-show').on('shown.bs.modal', () => $('#tokens-show-token').focus())
        },
    }
</script>
