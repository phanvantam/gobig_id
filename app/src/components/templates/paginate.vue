<template>
	<div class="clearfix">
	   <span class="pull-left">Có tổng sổ {{ total_record }} bản ghi</span>
	   <ul class="pagination pagination-sm no-margin pull-right" v-if="data !== null && data.list.length > 1">
	      <li v-for="item in data.list" :class="{active: data.current === item.data.page}" >
	         <span v-if="item.type == 'space'">...</span>
	         <span v-else @click="selectPage(item.data.page)">
	         	{{ item.data.page }}
	      	</span>
	       </li>
	   </ul>
	</div>
</template>

<script type="text/javascript">
import HelperIndex from '@/helper/index';

export default {
	data: ()=> ({
		data: null
	}),
	props: {
		page_total: {
			type: Number
		},
		page_current: {
			type: Number
		},
		total_record: {
			type: Number
		},
	},
	watch: {
		page_total: 'getData',
		page_current: 'getData'
	},
	methods: {
		getData() {
			let result = HelperIndex.paginate(this.page_total, this.page_current);
			this.data = result;
		},
		selectPage(value) {
			this.$emit('update:page_current', value);
		}
	}
}
</script>