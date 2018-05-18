<template>
    <div>
        <h2>{{$t('messages.index_title')}}</h2>
        <h4>{{$t('messages.validation_title')}}</h4>
        <input type="text"
               v-model="text"
               v-on:input="$v.text.$touch"
               v-bind:class="{error: $v.text.$error, valid: $v.text.$dirty && !$v.text.$invalid}"
        >
        <span class="form-group__message" v-if="!$v.text.required">{{$t('messages.error_required')}}</span>
        <span class="form-group__message" v-if="!$v.text.minLength">{{$t('messages.error_min_lenght', { value: $v.text.$params.minLength.min})}}</span>
    </div>
</template>

<script>
    import {validationMixin} from 'vuelidate';
    import {required, minLength, between} from 'vuelidate/lib/validators';

    export default {
        name: 'Index',
        data() {
            return {
                text: '',
            };
        },
        mixins: [validationMixin],
        validations: {
            text: {
                required,
                minLength: minLength(5),
            },
        },
    };
</script>

<style scoped>
    input {
        border: 1px solid silver;
        border-radius: 4px;
        background: white;
        padding: 5px 10px;
    }

    .error {
        border-color: red;
        background: #FDD;
    }

    .error:focus {
        outline-color: #F99;
    }

    .valid {
        border-color: #5A5;
        background: #EFE;
    }

    .valid:focus {
        outline-color: #8E8;
    }
</style>