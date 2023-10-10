<script>
export default {
    props: ['total', 'subs'],
    data() {
        return {
            localTotal: null,
            localSubs: this.subs,
            dateDu: '',
            dateAu: ''
        }
    },
    computed: {
        montantTotal() {
            var total = 0;
            this.localSubs.forEach(element => {
                if (element.produit[0]) {
                    if (element.produit[0].price_including_tax) {
                        total += element.produit[0].price_including_tax
                    }
                }

            });
            return total;
        }
    },
    watch: {
        dateDu() {

            if (this.dateAu === '') {
                this.localSubs = this.subs.filter(each => {
                    return (Date.parse(this.dateDu) < Date.parse(each.created_at))
                })
            } else {
                this.localSubs = this.subs.filter(each => {
                    return (Date.parse(this.dateDu) < Date.parse(each.created_at) && Date.parse(this.dateAu) > Date.parse(each.created_at))
                })
                if (this.dateDu === '') {
                    this.localSubs = this.subs.filter(each => {
                        return (Date.parse(this.dateAu) > Date.parse(each.created_at))
                    })
                }
            }

            if (this.dateDu === '' && this.dateAu === '') {
                this.localSubs = this.subs
            }
        },
        dateAu() {
            if (this.dateDu === '') {
                this.localSubs = this.subs.filter(each => {
                    return (Date.parse(this.dateAu) > Date.parse(each.created_at))
                })
            } else {
                this.localSubs = this.subs.filter(each => {
                    return (Date.parse(this.dateDu) < Date.parse(each.created_at) && Date.parse(this.dateAu) > Date.parse(each.created_at))
                })
                if (this.dateAu === '') {
                    this.localSubs = this.subs.filter(each => {
                        return (Date.parse(this.dateDu) < Date.parse(each.created_at))
                    })
                }
            }
            if (this.dateDu === '' && this.dateAu === '') {
                this.localSubs = this.subs
            }
        },
    },
    methods: {

    },
    created() {
        this.localSubs = this.subs
        this.localTotal = this.total;
        // this.montantTotal = this.total
    }
}
</script>