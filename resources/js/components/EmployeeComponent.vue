<template>
    <div>
        <p>
            <button type="button" class="btn btn-success" @click="create()">{{ translate.employees.add }}</button>
        </p>
        <b-table
            id="table"
            ref="table"
            :show-empty="!table.isLoading"
            stacked="lg"
            hover
            :emptyText="translate.employees.empty"
            :busy="table.isLoading"
            :items="table.data"
            :fields="table.fields"
            :current-page="table.currentPage"
            :per-page="table.perPage"
        >
            <template slot="actions" slot-scope="row">
                <button type="button" class="btn btn-primary btn-sm mb-1" @click="update(row.item.id)">{{ translate.buttons.edit }}</button>

                <button type="submit" class="btn btn-danger btn-sm mb-1" @click="destroy(row.item.id)">{{ translate.buttons.delete }}</button>
            </template>
        </b-table>

        <b-pagination
            v-if="!table.isLoading"
            v-model="table.currentPage"
            :total-rows="table.totalRows"
            :per-page="table.perPage"
            aria-controls="table"
        ></b-pagination>

        <b-modal 
            id="employee-modal" 
            ref="employeeModal"
            :title="title" 
            :okTitle="edit != 0 ? translate.buttons.edit : translate.buttons.submit" 
            :cancelTitle="translate.buttons.cancel"
            :okDisabled="disabled"
            @ok="handleOk"
            @show="resetForm"
            @hidden="resetForm"
        >
            <b-form @keydown="disabled = false" @submit.stop.prevent="handleSubmit" enctype="multipart/form-data" ref="form">
                <b-form-group :label="translate.employees.fields.firstname" label-for="firstname">
                    <b-form-input
                        id="firstname"
                        name="firstname"
                        :class="{ 'is-invalid': errors.firstname }"
                        @keydown="delete errors.firstname"
                        v-model="data.firstname"
                        required
                    ></b-form-input>
                    <span class="invalid-feedback" role="alert" v-if="errors.firstname">
                        <strong>{{ errors.firstname[0] }}</strong>
                    </span>
                </b-form-group>

                <b-form-group :label="translate.employees.fields.lastname" label-for="lastname">
                    <b-form-input
                        id="lastname"
                        name="lastname"
                        :class="{ 'is-invalid': errors.lastname }"
                        @keydown="delete errors.lastname"
                        v-model="data.lastname"
                        required
                    ></b-form-input>
                    <span class="invalid-feedback" role="alert" v-if="errors.lastname">
                        <strong>{{ errors.lastname[0] }}</strong>
                    </span>
                </b-form-group>

                <b-form-group :label="translate.employees.fields.company" label-for="logo">
                    <b-form-select 
                        v-model="data.company_id" 
                        name="company" 
                        :class="{ 'is-invalid': errors.company }"
                        :options="companies"
                        value-field="id"
                        text-field="name"
                        @change="disabled = false"
                        required
                    ></b-form-select>
                    <span class="invalid-feedback" role="alert" v-if="errors.company">
                        <strong>{{ errors.company[0] }}</strong>
                    </span>
                </b-form-group>

                <b-form-group :label="translate.employees.fields.email" label-for="email">
                    <b-form-input
                        id="email"
                        name="email"
                        v-model="data.email"
                        type="email"
                    ></b-form-input>
                </b-form-group>

                <b-form-group :label="translate.employees.fields.phone" label-for="phonenumber">
                    <b-form-input
                        id="phonenumber"
                        name="phonenumber"
                        v-model="data.phonenumber"
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
            companies: {},
            translate: {
                employees: {
                    fields: {}
                },
                buttons: {}
            },
            table: {
                data: [],
                fields: [
                { key: 'firstname', sortable: true, class: 'text-center', class: 'align-middle' },
                { key: 'lastname', sortable: true, sortDirection: 'asc', class: 'align-middle' },
                { key: 'company.name', sortable: true, thClass: 'text-center', class: 'align-middle' },
                { key: 'email', sortable: true, thClass: 'text-center', class: 'align-middle' },
                { key: 'phonenumber', sortable: true, thClass: 'text-center', class: 'align-middle' },
                { key: 'actions', class: 'text-center align-middle' }
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
            .then(response => {
                this.translate = response.data;
                Object.keys(this.translate.employees.fields).map((key, index) => {
                    this.table.fields[index].label = this.translate.employees.fields[key];
                });
            })
            .catch(error => this.$root.$emit('showAlert', error.response.data, "danger"));
        axios.get('/modal/employees')
            .then(response => {
                this.table.data = response.data;
                this.table.totalRows = this.table.data.length;
                this.table.isLoading = false;
            })
            .catch(error => this.$root.$emit('showAlert', error.response.data, "danger"));
        axios.get('/modal/companies')
            .then(response => this.companies = response.data )
            .catch(error => this.$root.$emit('showAlert', error.response.data, "danger"));
    },

    methods: {
        create() {
            this.edit = 0;
            this.title = this.translate.employees.add;
            this.$refs.employeeModal.show()
        },
        update(id) {
            axios.get('/employees/' + id)
                .then(response => {
                    this.data = response.data;
                    this.title = this.translate.buttons.edit + ' ' + this.data.firstname + ' ' + this.data.lastname;
                })
                .catch(error => {
                    console.log(error);
                });
            
            this.edit = id;
            this.editIndex = this.table.data.findIndex(x => x.id === id);
            this.$refs.employeeModal.show()
        },
        destroy(id) {
            const postData = {
                "_method": "DELETE",
                "_token": this.csrf
            };
            axios.post('/employees/' + id, postData)
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

            axios.post('/employees' + (this.edit != 0 ? '/' + this.edit : ''), formData)
                .then(response => {
                    if(response.status === 201)
                    {
                        if(this.edit != 0) {
                            Object.keys(response.data.data).map(key => {
                                this.table.data[this.editIndex][key] = response.data.data[key];
                            });
                            var index = this.companies.findIndex(x => x.id == response.data.data.company_id)
                            this.table.data[this.editIndex].company.name = this.companies[index].name;
                        }
                        else
                            this.table.data.push(response.data.data);

                        this.table.totalRows = this.table.data.length;

                        this.$nextTick(() => {
                            this.$refs.employeeModal.hide();
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