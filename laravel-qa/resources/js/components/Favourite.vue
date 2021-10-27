<template>
    <a title="Click to mark as favourite question (Click again to undo)"
        :class="classes" @click.prevent="toggle">
        <i class="fas fa-star fa-2x"></i>
        <span class="favourites-count">{{ count }}</span>
    </a>
</template>
<script>
export default {
    props: ['question'],

    data () {
        return {
            isFavourated: this.question.is_favourated,
            count: this.question.favourates_count,
            id: this.question.id
        }
    },

    computed: {
        classes () {
            return [
                'favourite', 'mt-2',
                ! this.signedIn ? 'off' : (this.isFavourated ? 'favourated' : '')
            ];
        },

        endpoint () {
            return `/questions/${this.id }/favourites`;
        }
    },

    methods: {
        toggle () {
            if (! this.signedIn) {
                this.$toast.warning("Please login to favourite this question", "warning", {
                    timeout: 3000,
                    position: 'bottomLeft'
                });
                return;
            }
            this.isFavourated ? this.destroy() : this.create();
        },

        destroy () {
            axios.delete(this.endpoint)
            .then(res=> {
                this.count--;
                this.isFavourated = false;
            });
        },

        create () {
            axios.post(this.endpoint)
            .then(res=> {
                this.count++;
                this.isFavourated = true;
            })
        }
    }
}
</script>
