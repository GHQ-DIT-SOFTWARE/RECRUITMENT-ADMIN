<template>
    <div>
        <div class="card text-left ">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-0">Records</h6>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" ref="awardModal"
                        data-bs-target="#awardModal">New Record</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm advance-table table-striped table-hover " data-auto-responsive="true">
                        <button id="refresh_table" style="display:none" ref="refresh_table">refresh table</button>
                        <thead>
                            <tr class="bg-dark text-white">
                                <th style="width:1%">#</th>
                                <th>Applicant Name</th>
                                <th>Arm of Service</th>
                                <th>Branch</th>
                                <th>Commission Type</th>
                                <th>Qualification</th>
                                <th>Age</th>
                                <th>Status</th>
                                <th>Authority/Remarks</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>
  
<script>
import Form from 'vform'
import {
    Button,
    HasError,
    AlertError,
    AlertSuccess
} from 'vform/src/components/bootstrap5'





export default {
    components: {
        Button,
        HasError,
        AlertError,
        AlertSuccess,

    },
    data: () => ({
        courses: '',
        current_record: '',

    }),
    methods: {
        // submit() {

        //     if (this.current_record == '') {
        //         let loader = this.$loading.show({
        //             container: this.$refs.formContainer,
        //         });

        //         this.form.post(this.route('api.admin.mech.step.course.store'))
        //             .then(({
        //                 data
        //             }) => {
        //                 loader.hide()
        //                 this.$toast.open('Operation Successful');

        //                 this.form.reset()
        //                 this.$refs.refresh_table.click()

        //             })
        //             .catch((error) => {
        //                 loader.hide()
        //             });

        //     } else {

        //         this.$refs.awardModal.click()

        //         this.$modal.show('dialog', {
        //             title: '<span class="dialog-popup" >Are you sure about this?</span>',
        //             buttons: [{
        //                 title: 'No',
        //                 handler: () => {
        //                     this.$modal.hide('dialog')
        //                 }
        //             },
        //             {
        //                 title: 'Yes',
        //                 handler: () => {

        //                     this.$modal.hide('dialog')
        //                     let loader = this.$loading.show({
        //                         container: this.$refs.formContainer,
        //                     });

        //                     this.form.patch(this.route('api.admin.mech.step.course.update', this.current_record))
        //                         .then(({
        //                             data
        //                         }) => {

        //                             loader.hide()
        //                             this.$toast.open('Saved');
        //                             this.$refs.refresh_table.click()
        //                             this.form.reset()
        //                             this.form.clear()
        //                             this.current_record = ''

        //                         })
        //                         .catch((error) => {
        //                             if (error.response.status == 422) {
        //                                 this.$refs.awardModal.click()
        //                             }
        //                             loader.hide()
        //                         });

        //                 }
        //             },

        //             ]
        //         })
        //     }
        // },


        makeDatatable() {
            var this_component = this;
            $(document).ready(function () {
                var table = $('.advance-table').DataTable({
                    ajax: this_component.route('step.applicant.index'),
                    serverSide: true,
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
                        width: "100px"
                    },
                    {
                        data: 'commission_type',
                        name: 'commission_type',
                        width: "80px"
                    },
                    {
                        data: 'branch',
                        name: 'branch',
                        width: "80px"
                    },

                    {
                        data: 'qualification',
                        name: 'qualification',

                    },
                    {
                        data: 'sex',
                        name: 'sex'
                    },

                    {
                        data: 'marital_status',
                        name: 'marital_status'
                    },
                    {
                        data: 'place_of_birth',
                        name: 'place_of_birth'
                    },


                    {
                        data: 'hometown',
                        name: 'hometown'
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
                            this_component.current_record = response.data
                            this_component.$refs.awardModal.click()

                            this_component.form.course_type.value = response.data.course_type
                            this_component.form.start_date = response.data.start_date
                            this_component.form.end_date = response.data.end_date

                            this_component.form.location = response.data.location
                            this_component.form.grade.value = response.data.grade
                            this_component.form.grading_type.value = response.data.grading_type
                            this_component.form.course_name.value = response.data.course_name
                            this_component.form.institution = response.data.institution
                            this_component.form.authority_remarks = response.data.authority_remarks

                            this_component.form.input_course_name = response.data.course_type != 'CAREER & STAFF' ? response.data.course_name : ''
                        })
                        .catch(error => {
                            this_component.$modal.hide('dialog')
                        });

                })


            });

        },
        resetModal() {
            this.form.reset()
            this.form.clear()
            this.current_record = ''
        }
    },
    created() {
        this.courses = window.app.course_types
        this.makeDatatable()
    },
    mounted() {
    }

}
</script>
  