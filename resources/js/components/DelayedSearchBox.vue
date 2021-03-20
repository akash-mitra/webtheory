<template>
    <div :class="wrapperClass">
        <label>
            <input
                v-model="searchPhrase"
                :class="inputClass"
                :placeholder="placeholder"
                name="search"
                type="text"
                @keyup="doDelayedSearch"
            />
        </label>
        <span :class="statusClass">
                {{ searchStatus }}
        </span>
    </div>
</template>

<script>
export default {
    name: "DelayedSearchBox",
    props: {
        'searchStatus': {
            type: String,
            default: ''
        },
        'placeholder': {
            type: String,
            default: 'Search...'
        },
        'wrapperClass': {
            type: String,
            default: 'px-6 relative'
        },
        'inputClass': {
            type: String,
            default: 'w-full rounded-lg shadow px-4 py-3 text-sm focus:outline-none'
        },
        'statusClass': {
            type: String,
            default: 'absolute inset-y-0 right-0 pr-12 flex items-center text-gray-700'
        },
        'searchDelay': {
            type: Number,
            default: 300
        }
    },
    data() {
        return {
            searchPhrase: ''
        }
    },

    methods: {
        doDelayedSearch() {

            if (this.timer) {
                clearTimeout(this.timer)
                this.timer = null
            }

            this.timer = setTimeout(() => {
                this.$emit('searched', this.searchPhrase)
            }, this.searchDelay)
        }
    }
}
</script>
