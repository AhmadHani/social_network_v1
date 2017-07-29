<template>
    <div class="container">
        <div class="row">
            <p v-show="loading">
                Loading ....
            </p>
            <p v-if="!loading">
                <button class="btn btn-success" v-if="status == 0" @click="add_friend">Add Friend</button>
                <button class="btn btn-success" v-if="status == 'pending'" @click="accept_friend">Accept Friend</button>
                <span class="text-success" v-if="status == 'waiting'">Waiting for response</span>
                <span class="text-success" v-if="status == 'friends'">Friends</span>

            </p>
        </div>
    </div>
</template>
<script>
    export default{
    mounted(){
        axios.get("/check/"+this.id).then((resp)=>{
            console.log(resp.data.status);
            this.status = resp.data.status;
            this.loading = false;
        });

    },
        props:['id'],
    data(){
        return {
            loading:true,
            status:''
        }
    },

methods:{
        add_friend(){
            this.loading = true;
            axios.get("/add_friend/"+this.id).then((resp)=>{
                if(resp.data == 1) {
                    this.status = "waiting";
                    new Noty({
                        type:'success',
                        layout:"bottomLeft",
                        text:"you send a friend request"
                    }).show();
                    this.loading = false;
                }
            });
        },
    accept_friend(){
        this.loading= true;
        axios.get("/accept_friend/"+this.id).then((resp)=>{
            this.status = "friends";

            new Noty({
                type:'success',
                layout:"bottomLeft",
                text:"friends right now !:)"
            }).show();
            this.loading = false;
        });
    }
}
    }
</script>