<template>
    <div class="modal modal_sc1" id="user-children">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Thêm người dùng cấp dưới</h4>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Ngày tạo</th>
                              </tr>
                            </thead>
                            <tbody class="table-product-body">
                              <tr v-for="(item, stt) in users_child">
                                <td>{{ stt+1 }}</td>
                                <td>{{ item.fullname }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.created_at }}</td>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                    <div>
                         <paginate 
                        :page_total="component.paginate.page_total"
                        :page_current.sync="component.paginate.page_current"
                        :total_record="component.paginate.total_record"
                        />
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger close-modal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserRepository from '@/repositories/UserRepository';

export default {
    data: ()=> ({
        users_child: [],
        component: {
            paginate: {
            page_total: 0,
            page_current: 0,
            total_record: 0
          }
        },
        params: {
      page: 1,
      per: 1
    }
    }),
    props: {
        user_id: {
            type: Number
        }
    },
    components: {
        paginate: ()=> import('@/components/templates/paginate.vue')
    },
    watch: {
        user_id: function() {
            this.params.page = 1;
            this.getData();
        },
        'component.paginate.page_current': function(value) {
            if(value !== this.params.page) {
                this.params.page = value;
                this.getData();
            }
        },
    },
    methods: {
        async getData() {
            const response = await UserRepository.getChild(this.user_id, {
        page: this.params.page,
        page_per: this.params.per,
      });

            this.users_child = response.users;
            this.component.paginate.page_total = response.paginate.total;
            this.component.paginate.page_current = response.paginate.current;
            this.component.paginate.total_record = response.paginate.total_record;
        },
        async remove(id) {
            if(confirm('Xác nhận xoá nội dung này')) {
                const result = await UserRepository.childRemove(id);
                if(parseInt(result.status) === 1) {
                    this.getData();
                    this.$notify({
                        text: 'Gỡ nhân viên thành công',
                        type: 'success'
                    })
                }
            }
        }
    }
}
</script>