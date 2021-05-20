<template>
    <div class="progress">
        <div class="percentage">
            {{ percentage }}%
        </div>
        <div class="max-bar">
            <div class="value-fill" :style="{ width: percentage + '%' }"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Progress',
    props: {
        value: {
            type: Number,
            required: true
        },
        max: {
            type: Number,
            default: 100
        }
    },
    computed: {
        percentage() {
            return Math.round((this.max / 100) * this.value);
        }
    }
}
</script>
