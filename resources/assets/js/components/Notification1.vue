<template>
    <div>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.listen()
        },
        props: ['id'],
        methods: {
            listen(){

                Echo.private('App.User.' + this.id)
                    .notification( (notification) => {
this.$store.commit("add_not",notification)
                        document.getElementById("s").innerHTML="hELLO";

                    })
            }
        }
    }
</script>