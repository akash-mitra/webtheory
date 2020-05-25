<template>
    <div v-show="needle === '' || (needle !== '' && (hasNeedle || childHasNeedle > 0))" class="">

        <div class="flex items-center">
            <svg v-if="level>1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-6 w-6 fill-current text-blue-300 mx-1"><path d="M511 316l-2-4-128-128a11 11 0 00-15 16l110 109H267A246 246 0 0121 64a11 11 0 00-21 0c0 147 120 267 267 267h209L366 440a11 11 0 0015 16l128-128 2-4v-8z"/></svg>

            <div class="px-4 py-2 w-full flex items-center justify-between rounded border" :class="hasNeedle? 'bg-yellow-200':'bg-white'">
                <div class="w-5/6">
                    <p class="text-blue-700" :class="level===1? 'font-bold':''">
                        <router-link :to="{ name: 'categories.edit', params: { id: item.id }}">{{item.name}}</router-link>
                    </p>
                    <p class="text-xs text-gray-700">{{item.description}}</p>
                </div>
                <div class="w-1/6 text-right">
                    <a :href="'/categories/' + item.id" class="text-xs text-blue-800">View</a>
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