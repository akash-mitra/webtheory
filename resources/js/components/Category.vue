<template>
    <div v-show="needle === '' || (needle !== '' && (hasNeedle || childHasNeedle > 0))" class="">

        <div class="flex items-center">
            <svg v-if="level>1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6 fill-current text-blue-300 mx-1"><path d="M511 316l-2-4-128-128a11 11 0 00-15 16l110 109H267A246 246 0 0121 64a11 11 0 00-21 0c0 147 120 267 267 267h209L366 440a11 11 0 0015 16l128-128 2-4v-8z"/></svg>

            <div class="p-4 w-full flex items-start justify-start rounded border" :class="hasNeedle? 'bg-yellow-200':'bg-white'">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mr-3 flex-shrink-0 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>

                <div class="flex-grow">
                    <p class="text-blue-700" :class="level===1? 'font-bold':''">
                        <router-link :id="'show-category-' + item.id" :to="{ name: 'categories.edit', params: { id: item.id }}">{{item.name}}</router-link>
                    </p>
                    <p class="text-xs text-gray-700">{{item.description}}</p>
                </div>

                <div class="text-right flex-grow-0 px-6">
                    <a :id="'view-category-' + item.id" :href="'/categories/' + item.id" class="text-xs text-blue-800 px-3 py-1 bg-indigo-100">View</a>
                </div>

            </div>

        </div>


        <div v-show="item.children.length > 0" :class="level>1?'pl-10':''">

                <Category
                    :item="subitem"
                    :key="subitem.id"
                    :level="level+1"
                    :needle="needle"
                    v-for="subitem in item.children"
                    @NeedleFound="onNeedleFoundAtChild"></Category>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        item: {
            type: Object,
            required: true
        },

        level: {
            type: Number,
            default: 1
        },

        needle: {
            type: String,
            default: ''
        }
    },

    name: 'Category',

    data() {
        return {
            childHasNeedle: 0
        }
    },

    computed: {
        hasNeedle () {
            if (this.needle === '') return false
            return this.item.name.toLowerCase().indexOf(this.needle.toLowerCase()) >= 0
        },
    },

    watch: {
        hasNeedle(newValue) {
            this.$emit ('NeedleFound', newValue)
        },

        childHasNeedle(newValue) {
            this.$emit ('NeedleFound', newValue)
        }
    },

    methods: {
        onNeedleFoundAtChild (value) {
            if (value) this.childHasNeedle++
            else this.childHasNeedle--

        }
    }
}
</script>