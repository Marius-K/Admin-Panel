<template>
    <div>
        <p>
            <button type="button" class="btn btn-success" @click="create()">{{ translate.companies.add }}</button>
        </p>
        <b-table
            id="table"
            ref="table"
            :show-empty="!table.isLoading"
            stacked="lg"
            small
            striped
            primary-key="id"
            :emptyText="translate.companies.empty"
            :busy="table.isLoading"
            :items="table.data"
            :fields="table.fields"
            :current-page="table.currentPage"
            per-page="10"
        >
            <template slot="logo" slot-scope="row">
                <img :src="row.value" class="img-thumbnail">
            </template>

            <template slot="website" slot-scope="row">
                <a :href="row.value">{{ row.value }}</a>
            </template>

            <template slot="actions" slot-scope="row">
                <button type="button" class="btn btn-primary btn-sm mb-1" @click="update(row.item.id, row.index)">{{ translate.buttons.edit }}</button>

                <button type="submit" class="btn btn-danger btn-sm mb-1" @click="destroy(row.item.id, row.index)">{{ translate.buttons.delete }}</button>
            </template>
        </b-table>

        <b-pagination
            v-model="table.currentPage"
            :total-rows="table.totalRows"
            :per-page="table.perPage"
            aria-controls="table"
        ></b-pagination>
        <!--<b-table :data="companies" :loading="isLoading" striped paginated pagination-simple per-page="10">
            <template slot-scope="props">
                <b-table-column field="logo" :label="translate.companies.fields.logo" width="100">
                    <img :src="props.row.logo" class="img-thumbnail">
                </b-table-column>

                <b-table-column field="name" :label="translate.companies.fields.name" sortable>
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column field="email" :label="translate.companies.fields.email" sortable>
                    {{ props.row.email }}
                </b-table-column>

                <b-table-column field="website" :label="translate.companies.fields.website" sortable>
                    <a :href="props.row.website">{{ props.row.website }}</a>
                </b-table-column>

                <b-table-column field="id" :label="translate.companies.fields.action" centered>
                    <button type="button" class="btn btn-primary btn-sm mb-1" @click="update(props.row.id, props.index)">{{ translate.buttons.edit }}</button>

                    <button type="button" class="btn btn-danger btn-sm mb-1" @click="destroy(props.row.id, props.index)">{{ translate.buttons.delete }}</button>
                </b-table-column>
            </template>

            <template slot="empty">
                <section class="section">
                    <div class="content has-text-grey has-text-centered">
                        <p>
                            <b-icon
                                icon="emoticon-sad"
                                size="is-large">
                            </b-icon>
                        </p>
                        <p>{{ translate.companies.empty }}</p>
                    </div>
                </section>
            </template>
        </b-table> -->
        <!--<div class="table-responsive">
            <table class="table table-striped table-sm" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center" style="width: 20%">{{ translate.companies.fields.logo }}</th>
                        <th scope="col" class="text-center" style="width: 25%">{{ translate.companies.fields.name }}</th>
                        <th scope="col" class="text-center" style="width: 20%">{{ translate.companies.fields.email }}</th>
                        <th scope="col" class="text-center" style="width: 20%">{{ translate.companies.fields.website }}</th>
                        <th scope="col" class="text-center" style="width: 15%">{{ translate.companies.fields.action }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company, key) in companies" :key="company.id">
                        <td class="align-middle"><img :src="company.logo" class="img-thumbnail"></td>
                        <td class="align-middle">{{ company.name }}</td>
                        <td class="align-middle">{{ company.email }}</td>
                        <td class="align-middle"><a :href="company.website">{{ company.website }}</a></td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-primary btn-sm mb-1" @click="update(company.id)">{{ translate.buttons.edit }}</button>

                            <button type="submit" class="btn btn-danger btn-sm" @click="destroy(company.id, key)">{{ translate.buttons.delete }}</button>
                        </td>
                    </tr>
                        
                    <tr v-if="companies.length === 0">
                        <td colspan="5"><p class="text-center">{{ translate.companies.empty }}</p></td>
                    </tr>
                </tbody>
            </table>
        </div>-->
        <b-modal 
            id="company-modal" 
            ref="companyModal"
            :title="title" 
            :okTitle="edit != 0 ? translate.buttons.edit : translate.buttons.submit" 
            :cancelTitle="translate.buttons.cancel"
            :okDisabled="disabled"
            @ok="handleOk"
            @show="resetForm"
            @hidden="resetForm"
        >
            <b-form @keydown="disabled = false" @submit.stop.prevent="handleSubmit" enctype="multipart/form-data" ref="form">
                <b-form-group :label="translate.companies.fields.name" label-for="name">
                    <b-form-input
                        id="name"
                        name="name"
                        :class="{ 'is-invalid': errors.name }"
                        @keydown="delete errors.name"
                        v-model="data.name"
                    ></b-form-input>
                    <span class="invalid-feedback" role="alert" v-if="errors.name">
                        <b>{{ errors.name[0] }}</b>
                    </span>
                </b-form-group>

                <b-form-group :label="translate.companies.fields.email" label-for="email">
                    <b-form-input
                        id="email"
                        name="email"
                        v-model="data.email"
                        type="email"
                    ></b-form-input>
                </b-form-group>

                <b-form-group :label="translate.companies.fields.logo" label-for="logo">
                        <b-form-file
                            id="logo"
                            name="logo"
                            accept="image/*"
                            v-model="data.logo"
                            :placeholder="translate.companies.fields.choose"
                            :browseText="translate.buttons.browse"
                            :drop-placeholder="translate.companies.fields.drop"
                            :state="errors.logo ? 'invalid' : ''"
                            @change="disabled = false; delete errors.logo"
                        ></b-form-file>
                        <span class="invalid-feedback" style="display: block" role="alert" v-if="errors.logo">
                            <b>{{ errors.logo[0] }}</b>
                        </span>
                </b-form-group>

                <b-form-group :label="translate.companies.fields.website" label-for="website">
                    <b-form-input
                        id="website"
                        name="website"
                        v-model="data.website"
                    ></b-form-input>
                </b-form-group>
            </b-form>
        </b-modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            translate: {
                companies: {
                    fields: {}
                },
                buttons: {}
            },
            table: {
                data: [],
                fields: [
                { key: 'logo', label: 'Logo', class: 'text-center' },
                { key: 'name', label: 'Name', sortable: true, sortDirection: 'asc', class: 'text-center' },
                { key: 'email', label: 'Email', class: 'text-center' },
                { key: 'website', label: 'Website', class: 'text-center' },
                { key: 'actions', label: 'Action', class: 'text-center' }
                ],
                currentPage: 1,
                perPage: 10,
                isLoading: true,
                totalRows: 0
            },
            data: {},
            errors: {},
            title: "",
            disabled: true,
            edit: 0,
            editIndex: 0
        }
    },

    props: [
        'csrf'
    ],

    created() {
        axios.get('/modal/translate/main')
            .then(response => this.translate = response.data)
            .catch(error => this.$root.$emit('showAlert', error.response.data, "danger"));
        axios.get('/modal/companies')
            .then(response => {
                this.table.data = response.data;
                this.table.totalRows = this.table.data.length;
                this.table.isLoading = false;
            })
            .catch(error => this.$root.$emit('showAlert', error.response.data, "danger"));
    },

    methods: {
        create() {
            this.edit = 0;
            this.title = this.translate.companies.add;
            this.$refs.companyModal.show()
        },
        update(id, index) {
            axios.get('/companies/' + id)
                .then(response => {
                    this.data = response.data;
                    this.title = this.translate.buttons.edit + ' ' + this.data.name;
                })
                .catch(error => {
                    console.log(error);
                });
            
            this.edit = id;
            this.editIndex = this.table.data.findIndex(x => x.id === id);
            this.$refs.companyModal.show()
        },
        destroy(id, index) {
            const postData = {
                "_method": "DELETE",
                "_token": this.csrf
            };
            axios.post('/companies/' + id, postData)
                .then(response => {
                    Vue.delete(this.table.data, this.table.data.findIndex(x => x.id === id));
                    this.table.totalRows = this.table.data.length;
                    this.$root.$emit("showAlert", response.data, "success")
                })
                .catch(error => this.$root.$emit('showAlert', error.response.data, "danger"));
        },
        resetForm() {
            this.data = {};
            this.errors = {};
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault();
            this.handleSubmit();
        },
        handleSubmit() {
            this.disabled = true;
            let formData = new FormData(this.$refs.form);

            formData.append('_token', this.csrf);
            if(this.edit != 0)
                formData.append('_method', 'PATCH');

            axios.post('/companies' + (this.edit != 0 ? '/' + this.edit : ''), formData, {headers: {'Content-Type': 'multipart/form-data'}})
                .then(response => {
                    if(response.status === 201)
                    {
                        if(this.edit != 0) {
                            this.table.data[this.editIndex].logo = response.data.data.logo;
                            this.table.data[this.editIndex].name = response.data.data.name;
                            this.table.data[this.editIndex].email = response.data.data.email;
                            this.table.data[this.editIndex].website = response.data.data.website;
                        }
                        else
                            this.table.data.push(response.data.data);

                        this.table.totalRows = this.table.data.length;

                        this.$nextTick(() => {
                            this.$refs.companyModal.hide();
                        })
                        this.$root.$emit("showAlert", response.data.status, "success");
                    }
                })
                .catch(error => {
                    if (error.response.status === 422)
                        this.errors = error.response.data.errors || {};
                });
        }
    }
}
</script>