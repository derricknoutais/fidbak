<template>
    <div class='container mt-5'>
        <div class="row">
            <div class="col-12">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action " v-for="sub in subzeros"><span>{{ sub.nom
                    }}</span> <span class="badge badge-success badge-lg float-right">{{ sub.total }}</span></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['subs'],
    data() {
        return {
            subzeros: {}
        }
    },
    methods: {
    },
    created() {
        this.subzeros = this.subs
        var subs = (Object.values(this.subzeros));
        console.log(subs)
        subs.forEach(sub => {
            var total = 0;
            // sub.forEach( element => {
            total += sub.quantité
            // })
            sub['total'] = total
            console.log('Le Total est: ' + total)
        });
        this.subzeros = subs
    }
}
</script>
