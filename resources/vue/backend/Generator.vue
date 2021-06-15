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
                <button class="button button-primary" :class="{ disabled: generating }" @click="generate">Generate</button>
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
            generating: false,
            quantity: 10,
            generated: 0,
            amount: 0,
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
            if (this.generating) {
                return;
            }

            this.generating = true;
            this.generated = 0;
            this.batch();
        },
        batch() {
            const formData = new FormData();
            formData.append('quantity', this.batchSize);
            formData.append('amount', this.amount);

            axios.post('/wp-json/coupon-generator/v1/generate', formData).then((response) => {
                console.log(response.data);
                if (response.data.success === true) {
                    this.generated += this.batchSize;
                    if (this.batchSize > 0) {
                        this.batch();
                    } else {
                        //this.generating = false;
                        alert('Completed!');
                    }
                } 
            });
        }
    }
}
</script>
