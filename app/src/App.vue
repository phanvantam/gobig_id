<template>
    <div id="app">
        <notifications
            :max="10"
            style="bottom: 50px;right: 50px;"
            position="bottom right"
        />
        <component :is="layout">
            <router-view />
        </component>
    </div>
</template>

<script>
import HelperIndex from '@/helper/index.js';

export default {
    components: {
        layoutIndex: ()=> import('@/layouts/index.vue'),
        layoutClient: ()=> import('@/layouts/client.vue'),
    },
    computed: {
        layout() {
            if(this.$route.name !== null) {
                switch(HelperIndex.arrayGet(this.$route.meta, 'layout')) {
                    case 'client': 
                        return 'layoutClient'
                    break;
                    default:
                        return 'layoutIndex'
                    break;
                }
            }
        }
    },
}
</script>