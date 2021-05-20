<template>
    <div id="coupon-generator-app">
        <Progress :value="parseInt(generated)" :max="parseInt(quantity)" />
        <div class="generator-options">
            <h2>Options</h2>
            <div class="form-input">
                <label>Quantity</label>
                <input type="text" placeholder="0" v-model="quantity">
            </div>
            <div class="form-input">
                <label>Amount</label>
                <input type="text" placeholder="0" v-model="amount">
            </div>
            <div class="form-input">
                <button class="button button-primary" @click="generate">Generate</button>
            </div>
        </div>
    </div>
</template>

<script>
import Progress from './components/Progress.vue';
import axios from 'axios';

export default {
    name: 'Generator',
    components: {
        Progress
    },
    data() {
        return {
            quantity: 10,
            generated: 0,
            amount: '',
        };
    },
    computed: {
        batchSize() {
            const remaining = this.quantity - this.generated;

            if (remaining >= 10) {
                return 10;
            }

            return remaining;
        }
    },
    methods: {
        generate() {
            // TODO: hardcoded url
            axios.post('/wp-json/coupon-generator/v1/generate', {
                quantity: this.batchSize,
                amount: this.amount
            }).then((response) => {
                if (response.data.success === true) {
                    this.generated += 10;
                    if (this.batchSize > 0) {
                        this.generate();
                    } else {
                        alert('Completed!');
                    }
                } 
            });
        }
    }
}
</script>
