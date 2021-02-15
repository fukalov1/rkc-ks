<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-if="!auth">
                    <div class="card-header">Вход в личный кабинет</div>
                    <div class="card-body">
                        <h5 class="text-danger" v-if="message">
                            {{ message }}
                        </h5>
                        <form v-on:submit.prevent="onSubmitAuth">
                        <div class="row form-group">
                            <div class="col-12">
                                <label>
                                    Номер лицевого счета
                                </label>
                                <input class="form-control" required v-model="account"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label>
                                    Номер счетчика/код доступа
                                </label>
                                <input class="form-control" required v-model="code"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center form-group">

                            </div>
                        </div><div class="row">
                            <div class="col-12 text-center form-group">
                                <button class="btn btn-success">
                                    войти
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="card" v-else-if="auth">
                    <div class="card-header">
                        Клиент:
                        <strong>
                            {{ customer.clientname}}
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form v-on:submit.prevent="onSubmitData" v-if="!success">
                                     <label class="text-danger">
                                         Ввод показаний открыт с {{ check_day_start }} по {{ check_day_end }} число.
                                     </label>
                                    <div class="row form-group">
                                        <div class="col-md-4 d-none d-sm-block">
                                                Счетчик (Тип)
                                        </div>
                                        <div class="col-md-4 d-none d-sm-block">
                                                Предыдущее показание
                                        </div>
                                        <div class="col-md-4 d-none d-sm-block">
                                                Текущее показание
                                        </div>
                                    </div>
                                    <div class="row form-group lk-form"
                                         v-for="(device, index) in customer.devices" :key="index">

                                        <div class="col-md-4">
                                            <label class="col-sm-6 d-lg-none d-ld-block">
                                                Счетчик (Тип)
                                            </label>
                                            <span>
                                                {{ device.toolid }} ({{ device.tooltype }})
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="col-sm-6 d-lg-none d-ld-block">
                                                Предыдущее показание
                                            </label>
                                            <span>
                                                {{ device.value_old}}
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-sm-6 d-lg-none d-ld-block">
                                                Текущее показание
                                            </label>
                                            <input class="form-control"
                                                   required
                                                   v-if="curr_day>=check_day_start && curr_day<=check_day_end"
                                                   v-model="device.value_new"/>
                                            <span v-else>
                                                ввод недоступен
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center form-group">
                                            <button class="btn btn-success"
                                                    v-if="curr_day>=check_day_start && curr_day<=check_day_end">
                                                сохранить
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <h5 class="text-danger" v-else>
                                    {{ message }}
                                </h5>
                                <br/>
                            </div>
                            <div class="col-12">
                                <div class="row form-group">
                                    <div class="col-12 slips" v-for="(slip, index) in slips" :key="index">
                                        <strong v-if="index===0">
                                            Текущая квитанция<br/>
                                        </strong>
                                        <strong v-if="index===1">
                                            Архив квитанций<br/>
                                        </strong>
                                        <div col-12>
                                            <a :href="`http://www.rkc-ks.ru/ex/get.php?clientid=${uid}&year=${slip.year}&month=${slip.month_id}`" target="_blank">
                                                {{ slip.month }} {{ slip.year}} г.
                                            </a><br/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        name: 'ClientComponent',
        props: {
            qr_auth: {
                type: Number,
                default: 0
            },
            check_day_start: {
                type: Number,
                default: 20
            },
            check_day_end: {
                type: Number,
                default: 25
            },
        },
        data() {
            return {
                account: null,
                code: null,
                auth: this.qr_auth,
                success: false,
                message: null,
                customer: {
                    clientname: null,
                    devices: []
                },
                slips: [],
                uid: null
            }
        },
        mounted() {

        },
        created() {
            if (this.qr_auth) {
                this.existAuth();
            }
        },
        computed: {
            curr_day() {
                let today = new Date();
                return today.getDate()
            }
        },
        methods: {
            existAuth() {
                axios({
                    url: `/data/exist-auth`,
                    method: 'POST'
                })
                    .then(response => {
                        if (response.data.auth) {
                            this.auth = response.data.auth;
                            this.message = null;
                            this.customer = response.data.customer
                            this.getSlips();
                        }
                        else {
                            this.message = response.data.message;
                        }
                    })
                    .catch(error => {
                        this.message = 'Данные пользователя не найдены';
                    });
            },
            onSubmitAuth() {
                axios({
                    url: `/data/auth`,
                    method: 'POST',
                    data: {account: this.account, code: this.code}
                })
                    .then(response => {
                        if (response.data.auth) {
                            this.auth = response.data.auth;
                            this.message = null;
                            this.customer = response.data.customer
                            this.getSlips();
                        }
                        else {
                            this.message = response.data.message;
                        }
                    })
                    .catch(error => {
                        this.message = 'Данные пользователя не найдены';
                    });
            },
            onSubmitData() {
                axios({
                    url: `/data/send`,
                    method: 'POST',
                    data: {customer: this.customer}
                })
                    .then(response => {
                        if (response.data.success) {
                            this.success = response.data.success;
                        }
                        this.message = response.data.message;
                    })
                    .catch(error => {
                        this.message = 'Данные пользователя не найдены';
                    });
            },
            getSlips() {
                axios({
                    url: `/data/slips`,
                    method: 'POST'
                })
                    .then(response => {
                        if (response.data.uid) {
                            this.uid = response.data.uid;
                            this.slips = response.data.slips;
                        }
                        else {
                            this.message = response.data.message;
                        }

                    })
                    .catch(error => {
                        this.message = 'Данные пользователя не найдены';
                    });
            }
        }
    }
</script>
