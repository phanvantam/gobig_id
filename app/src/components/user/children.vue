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
                                <th v-if="$helper.user.permission('user.remove_child|user.manager')">Tác vụ</th>
                              </tr>
                            </thead>
                            <tbody class="table-product-body">
                              <tr v-for="item in users_child">
                                <td></td>
                                <td>{{ item.fullname }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.created_at }}</td>
                                <td v-if="$helper.user.permission('user.remove_child|user.manager')">
                                  <span class="label label-danger" @click="remove(item.child_id)">
                                    <i class="fa fa-trash"></i> Xoá
                                  </span>
                                </td>
                              </tr>
                            </tbody>
                          </table>
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
    }),
    props: {
        user_id: {
            type: Number
        }
    },
    watch: {
        user_id: 'getData'
    },
    methods: {
        getData() {
            UserRepository.getChild(this.user_id)
            .then(response=> {
                this.users_child = response;
            })
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