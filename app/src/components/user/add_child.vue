<template>
	<div class="modal modal_sc1" id="user-add-child">
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
	                <div class="form-group">
	                    <label for="">Tìm kiếm người dùng:</label>
	                    <vue_simple_suggest 
                            :list="component.vue_simple_suggest.search_user.data"
                            display-attribute="fullname"
                        >
                            <input 
                                type="search" 
                                placeholder="Họ tên hoặc email"
                                class="form-control"
                                v-model="component.vue_simple_suggest.search_user.query"
                                autofocus
                            />
                            <div slot="suggestion-item" slot-scope="{ suggestion, query }">
                                <div @click.stop="submit(suggestion)">{{ suggestion.fullname }} - {{ suggestion.email }}</div>
                            </div>
                        </vue_simple_suggest>
	                </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Ngày tạo</th>
                                <th>Tác vụ</th>
                              </tr>
                            </thead>
                            <tbody class="table-product-body">
                              <tr v-for="item in users_child">
                                <td></td>
                                <td>{{ item.fullname }}</td>
                                <td>{{ item.email }}</td>
                                <td>{{ item.created_at }}</td>
                                <td>
                                  <span class="label label-danger">
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
import VueSimpleSuggest from 'vue-simple-suggest';
import 'vue-simple-suggest/dist/styles.css';

export default {
    data: ()=> ({
        users_child: [],
        component: {
            vue_simple_suggest: {
                search_user: {
                    data: [],
                    query: null
                }
            }
        }
    }),
    components: {
        vue_simple_suggest: VueSimpleSuggest
    },
    props: {
        user_id: {
            type: Number
        }
    },
    watch: {
        'component.vue_simple_suggest.search_user.query': 'searchUser',
        user_id: 'getData'
    },
    created() {
    },
    methods: {
        submit(item) {
            let params = {
                parent_id: this.user_id,
                child_id: item.id,
            };
        	UserRepository.childAdd(params)
            .then(response=> {
                switch(response.status) {
                    case 1: 
                        this.getData();
                        this.$notify({
                            text: 'Thêm thành công',
                            type: 'success'
                        });
                    break;
                    case 0:
                        response.messages.list.map(value=> {
                            this.$notify({
                                text: value,
                                type: 'error'
                            })
                        });
                    break;
                }
            })
        },
        searchUser() {
            this.component.vue_simple_suggest.search_user.data = [];
            UserRepository.search({query: this.component.vue_simple_suggest.search_user.query})
            .then(response=> {
                this.component.vue_simple_suggest.search_user.data = response;
            })
        },
        getData() {
            UserRepository.getChild(this.user_id)
            .then(response=> {
                this.users_child = response;
            })
        },
    }
}
</script>