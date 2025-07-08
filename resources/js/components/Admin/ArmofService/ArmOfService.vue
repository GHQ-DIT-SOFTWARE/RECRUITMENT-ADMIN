<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-0">Arm of Service</h6>
                    </div>
                    <div class="btn-group btn-group-sm my-0">
                        <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Menu</button>
                        <div class="dropdown-menu" style="">
                            <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" ref="showModal"
                                data-bs-target="#showModal">Arm</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm advance-table table-striped table-hover " data-auto-responsive="true">
                        <button id="refresh_table" style="display:none" ref="refresh_table">refresh table</button>
                        <thead>
                            <tr class="bg-dark text-white">
                                <th style="width:1%">#</th>
                                <th>Arm of Service</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>


        <form @submit.prevent="submit" ref="formContainer" class="gy-3 form-settings vld-parent"
            @keydown="form.onKeydown($event)">
            <div id="showModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myExtraLargeModalLabel">Arm of Service</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" @click="resetModal()"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show mb-2"
                                role="alert">
                                <i class="ri-error-warning-line label-icon"></i><strong>Note</strong>
                                Please fill all information below
                            </div>
                            <AlertSuccess :form="form" message="Saved" />
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="arm_of_service">Arm of Service</label>
                                        <input type="text" class="form-control " placeholder=""
                                            v-model="form.arm_of_service"
                                            :class="{ 'is-invalid': form.errors.has('arm_of_service') }"
                                            id="arm_of_service">
                                        <has-error :form="form" field="arm_of_service"></has-error>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <Button :form="form" class="btn btn-primary btn-border">
                                Save
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
  
<script>
import Form from 'vform'
import {
    Button,
    HasError,
    AlertError,
    AlertSuccess,
} from 'vform/src/components/bootstrap5'



export default {
    components: {
        Button,
        HasError,
        AlertError,
        AlertSuccess,
    },

    data: () => ({
        current_record: '',
        form: new Form({
            arm_of_service: '',
        }),
    }),


    methods: {
        submit() {
            if (this.current_record == '') {
                let loader = this.$loading.show({
                    container: this.$refs.formContainer,
                });
                this.form.post(this.route('step.arm.store '))
                    .then(({
                        data
                    }) => {
                        loader.hide()
                        this.$toast.open('Operation Successful');
                        this.form.reset()
                        this.$refs.refresh_table.click()
                    })
                    .catch((error) => {
                        loader.hide()
                    });
            } else {
                this.$refs.showModal.click()
                this.$modal.show('dialog', {
                    title: '<span class="dialog-popup" >Are you sure about this?</span>',
                    buttons: [{
                        title: 'No',
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    },
                    {
                        title: 'Yes',
                        handler: () => {

                            this.$modal.hide('dialog')
                            let loader = this.$loading.show({
                                container: this.$refs.formContainer,
                            });
                            this.form.patch(this.route('step.arm.update', this.current_record))
                                .then(({
                                    data
                                }) => {
                                    loader.hide()
                                    this.$toast.open('Saved');
                                    this.$refs.refresh_table.click()
                                    this.form.reset()
                                    this.form.clear()
                                    this.current_record = ''
                                })
                                .catch((error) => {
                                    if (error.response.status == 422) {
                                        this.$refs.showModal.click()
                                    }
                                    loader.hide()
                                });
                        }
                    },

                    ]
                })
            }
        },
        makeDatatable() {
            var this_component = this;
            $(document).ready(function () {
                var table = $('.advance-table').DataTable({
                    ajax: this_component.route('step.arm.index'),
                    serverSide: true,
                    lengthMenu: [
                        [15, 25, 50, 100, 200, -1],
                        [15, 25, 50, 100, 200, 'All'],
                    ],
                    columns: [{
                        data: 'id',
                        searchable: false,
                        sortable: false,
                        orderable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1 + '.';
                        }
                    },
                    {
                        data: 'arm_of_service',
                        name: 'arm_of_service',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "text-center",
                        searchable: false,
                        sortable: false,
                        orderable: false,
                    },
                    ],
                    scrollY: 200,
                    scrollCollapse: true,
                    stateSave: true,
                    pagingType: "full_numbers",
                    processing: true,
                    drawCallback: function () {
                        $('.table tbody td').addClass("blurry");
                        //   $('.table tbody').fadeIn(800);
                        setTimeout(function () {
                            $('.table tbody td').removeClass("blurry");
                        }, 200);
                    }

                });

                $('#refresh_table').on('click', function () {
                    table.draw()
                })

                $('.table tbody').on('click', '.btn-delete', function () {

                    this_component.$modal.show('dialog', {
                        title: '<span class="dialog-popup" >Are you sure about this?</span>',
                        buttons: [{
                            title: 'No',
                            handler: () => {
                                this_component.$modal.hide('dialog')
                            }
                        },
                        {
                            title: 'Yes',
                            handler: () => {
                                axios.delete($(this).data('href'))
                                    .then(response => {

                                        this_component.$modal.hide('dialog')
                                        this_component.$toast.open('Operation Successful');
                                        $('#refresh_table').click()

                                    })
                                    .catch(error => {
                                        this_component.$modal.hide('dialog')
                                    });
                            }
                        },

                        ]
                    })

                })

                $('.table tbody').on('click', '.btn-edit', function () {

                    axios.get($(this).data('href'))
                        .then(response => {
                            this_component.current_record = response.data.uuid
                            this_component.$refs.showModal.click()
                            this_component.form.arm_of_service = response.data.arm_of_service
                        })
                        .catch(error => {
                            this_component.$modal.hide('dialog')
                        });

                })


            });

        },
    },
    created() {
        this.makeDatatable()
    },


}

</script>
  