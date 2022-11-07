<template>
    <div class="container-fluid">

        <div class="row d-flex">
            <div class=" d-flex flex-column align-items-center col-md-3">
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mt-3 btn-block" data-toggle="modal" data-target="#marque">Ajouter Marque</button>
                    <button type="button" class="btn btn-primary mt-3 btn-block" data-toggle="modal" data-target="#type">Ajouter Type</button>
                    <button type="button" class="btn btn-primary mt-3 btn-block" data-toggle="modal" data-target="#modèle">Ajouter Modèle, Moteur et Attribuer a Type</button>
                    <button type="button" class="btn btn-primary mt-3 btn-block" data-toggle="modal" data-target="#moteur">Ajouter Moteur</button>
                    <button type="button" class="btn btn-primary mt-3 btn-block" data-toggle="modal" data-target="#moteur_type">Attribuer un Moteur à un Type</button>
                    <button type="button" class="btn btn-primary mt-3 btn-block" data-toggle="modal" data-target="#modèle_type">Attribuer un Modèle à un Type</button>
            </div>
            <div class="col-md-4 offset-md-1 border p-3 bg-primary">
                <h1 class="text-center mt-5">Fiche de Renseignement</h1>
                <div class="form-group">
                    <label>Marque</label>
                    <multiselect v-model="fiche_renseignement.marque" :options="marques" label="nom" track-by="id" placeholder="Selectionne une Marque" @select="chercheType()">
                        <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                    </multiselect>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <multiselect v-model="fiche_renseignement.type" :options="types" label="nom" track-by="id" placeholder="Selectionne un Type" @select="chercheMoteurs()">
                        <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                    </multiselect>
                    <!-- <select type="text" class="form-control" v-model="fiche_renseignement.type" @change="chercheMoteurs()">
                        <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                    </select> -->
                </div>
                <div class="form-group">
                    <label>Modèle</label>
                    <multiselect v-model="fiche_renseignement.modèle" :options="modèles" label="nom" track-by="id" placeholder="Selectionne un Modèle" @select="chercheMoteurs()">
                        <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                    </multiselect>
                    <!-- <select type="text" class="form-control" v-model="fiche_renseignement.modèle">
                        <option :value="modèle.id" v-for="modèle in modèles" @change="chercheMoteurs()">{{ modèle.nom }}</option>
                    </select> -->
                </div>
                <div class="form-group">
                    <label>Moteur</label>
                    <multiselect v-model="fiche_renseignement.moteur" :options="moteurs" label="nom" track-by="id" placeholder="Selectionne un Moteur">
                        <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                    </multiselect>
                </div>
                <div class="form-group">
                    <label>Année</label>
                    <input type="text" class="form-control" v-model="fiche_renseignement.année">
                </div>
                <div class="form-group">
                    <label>Numéro de Chassis</label>
                    <input type="text" class="form-control" v-model="fiche_renseignement.chassis">
                </div>
                <div class="form-group">
                    <label>Lien Partsouq</label>
                    <input type="text" class="form-control" v-model="fiche_renseignement.détails">
                </div>
                <div class="form-group bg-info p-4">
                    <label class="d-block text-white">Articles Recherchés</label>
                    <div>
                        <input type="checkbox" v-model="fiche_renseignement.autreGroupeCheckBox" > <label for="">Autre Groupe</label>
                        <multiselect
                            v-if="! fiche_renseignement.autreGroupeCheckBox"
                            v-model="fiche_renseignement.handle" :options="handles" label="name" track-by="id" placeholder="Selectionne un Moteur">
                            <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.name }}</strong></template>

                        </multiselect>
                        <input
                            v-if=" fiche_renseignement.autreGroupeCheckBox"
                        type="text" class="form-control" v-model="fiche_renseignement.autreGroupe" placeholder="Reference">
                    <div class="input-group mt-3">
                        <input type="text" class="form-control" v-model="fiche_renseignement.reference" placeholder="Reference">
                        <input type="text" class="form-control" v-model="fiche_renseignement.autreInfo" placeholder="Autres Infos (Marques, etc)">
                        <div class="input-group-append">
                          <button class="btn btn-outline-success text-white bg-success" type="button" @click="ajouterArticles()">Ajouter</button>
                        </div>
                    </div>
                    </div>

                </div>
                <ol class="list-group list-group-flush offset-md-1 col-md-10 mt-5">
                    <li class="list-group-item" v-for="article in fiche_renseignement.articles">
                        {{ article.handle.name }}
                        {{ article.nom }}
                        ( {{ article.autreInfo }} )
                    </li>
                </ol>
                <div class="row justify-content-center mt-2">
                    <button class="btn btn-success" @click="enregistreLaFiche()">Enregistrer</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="marque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Marque</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_marque.marque"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUneMarque()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <multiselect v-model="formulaire_type.marque" :options="marques" label="nom" track-by="id" placeholder="Selectionne une Marque" @select="chercheType(formulaire_type.marque)">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                            <!-- <select type="text" class="form-control" v-model="formulaire_type.marque" @change="chercheType(formulaire_type.marque)">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select> -->
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_type.type"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnType()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modèle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Modèle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <multiselect v-model="formulaire_modèle.marque" :options="marques" label="nom" track-by="id" placeholder="Selectionne une Marque">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                            <!-- <select type="text" class="form-control" v-model="formulaire_modèle.marque">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select> -->
                        </div>

                        <div class="form-group">
                            <multiselect v-model="formulaire_modèle.type" :options="types" label="nom" track-by="id" placeholder="Attribuer a un Type">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_modèle.modèle" placeholder="Creer Modèle" />
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_modèle.moteur" placeholder="Creer Moteur"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnModèle()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="moteur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Moteur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <multiselect v-model="formulaire_moteur.marque" :options="marques" label="nom" track-by="id" placeholder="Selectionne une Marque">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                            <!-- <select type="text" class="form-control" v-model="formulaire_moteur.marque" @change="chercheType(formulaire_moteur.marque)">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select> -->
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_moteur.moteur" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnMoteur()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="moteur_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attribuer un Moteur à un Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <multiselect v-model="formulaire_type_moteur.type" :options="types" label="nom" track-by="id" placeholder="Selectionne un Type">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                        </div>
                        <div class="form-group">
                            <multiselect v-model="formulaire_type_moteur.moteur" :options="moteurs" label="nom" track-by="id" placeholder="Selectionne un Moteur">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnTypeAUnMoteur()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modèle_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attribuer un Modèle à un Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <multiselect v-model="formulaire_modèle_type.type" :options="types" label="nom" track-by="id" placeholder="Selectionne un Type">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                            <!-- <select type="text" class="form-control" v-model="formulaire_modèle_type.type">
                                <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                            </select> -->
                        </div>
                        <div class="form-group">
                            <multiselect v-model="formulaire_modèle_type.modèle" :options="modèles" label="nom" track-by="id" placeholder="Selectionne un Modele">
                                <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                            </multiselect>
                            <!-- <select type="text" class="form-control" v-model="formulaire_modèle_type.modèle">
                                <option :value="modèle.id" v-for="modèle in modèles">{{ modèle.nom }}</option>
                            </select> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnTypeAUnModèle()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    data(){
        return {
            'fiche_renseignement' : {
                marque: '',
                type: '',
                année: '',
                chassis: '',
                moteur: '',
                autreInfo: '',
                reference: '',
                handle : '',
                modèle: '',
                autreGroupeCheckBox : false,
                autreGroupe : '',
                articles: []
            },
            "formulaire_marque" : {
                marque: ''
            },
            "formulaire_type" : {
                marque: '',
                type: ''
            },
            "formulaire_moteur" : {
                marque: '',
                moteur: ''
            },
            "formulaire_type_moteur": {
                type: '',
                moteur: ''
            },
            "formulaire_modèle_type": {
                modèle: '',
                type: ''
            },
            "formulaire_modèle": {
                marque: '',
                modèle: '',
                type : null,
                moteur : null
            },
            marques: [],
            types: [],
            moteurs: [],
            modèles: [],
            handles : [],
            modal:{
                ajouter: '',
                attribuer: ''
            }
        }
    },
    methods: {
        ajouterArticles(){
            this.fiche_renseignement.articles.push(
                {
                    nom: this.fiche_renseignement.reference,
                    handle: this.fiche_renseignement.handle,
                    autreInfo : this.fiche_renseignement.autreInfo
                }

            )
            this.fiche_renseignement.reference = ''
            this.fiche_renseignement.autreInfo = ''
            this.$forceUpdate()
        },
        enregistreLaFiche(){

            this.fiche_renseignement.marque ? null : this.fiche_renseignement.marque = {'id' : null}
            this.fiche_renseignement.type ? null : this.fiche_renseignement.type = {'id' : null}
            this.fiche_renseignement.moteur ? null : this.fiche_renseignement.moteur = {'id' : null}
            this.fiche_renseignement.modèle ? null : this.fiche_renseignement.modèle = {'id' : null}

            axios.post('/fiche-renseignement/api/enregistrer', this.fiche_renseignement).then(response => {
                // location.reload();
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        chercheType(){
            setTimeout(() => {
                console.log(this.fiche_renseignement.marque.id)
                axios.get('/fiche-renseignement/type/de-marque/' + this.fiche_renseignement.marque.id).then(response => {
                    this.types = response.data;
                    console.log(response.data);
                    this.$forceUpdate()
                }).catch(error => {
                    console.log(error);
                });
            }, 100);

        },
        chercheMoteurs(){
            setTimeout(() => {
                axios.get('/fiche-renseignement/moteur/de-type/' + this.fiche_renseignement.type.id).then(response => {
                    if(response.data.moteurs.length > 0){
                        this.moteurs = response.data.moteurs;
                    }
                }).catch(error => {
                    console.log(error);
                });
                this.chercheModèles();
            }, 100);
        },
        chercheModèles(){
            setTimeout(() => {
                axios.get('/fiche-renseignement/modèle/de-type/' + this.fiche_renseignement.type.id).then(response => {
                    if(response.data.modèles.length > 0){
                        this.modèles = response.data.modèles;
                    } else {
                        this.modèles = []
                    }
                }).catch(error => {
                    console.log(error);
                });
            }, 100);
        },
        enregistreUneMarque(){
            axios.post('/fiche-renseignement/marque/api/enregistrer', this.formulaire_marque ).then(response => {
                console.log(response.data);
                location.reload();

            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnType(){
            axios.post('/fiche-renseignement/type/api/enregistrer', this.formulaire_type ).then( response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnModèle(){
            axios.post('/fiche-renseignement/modèle/api/enregistrer', this.formulaire_modèle ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnMoteur(){
            axios.post('/fiche-renseignement/moteur/api/enregistrer', this.formulaire_moteur ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnTypeAUnMoteur(){
            axios.post('/fiche-renseignement/type-moteur/api/enregistrer', this.formulaire_type_moteur ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnTypeAUnModèle(){
            axios.post('/fiche-renseignement/modèle-type/api/enregistrer', this.formulaire_modèle_type ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        displayModal(value){
            $(value).modal('show')
        },
        init(){
            axios.get('/fiche-renseignement/marque/api/all').then(response => {
                this.marques = response.data;
            });
            axios.get('/fiche-renseignement/type/api/all').then(response => {
                this.types = response.data;
            });
            axios.get('/fiche-renseignement/moteur/api/all').then(response => {
                this.moteurs = response.data;
            });
            axios.get('/fiche-renseignement/modèle/api/all').then(response => {
                this.modèles = response.data;
            });
            axios.get('/api/handles').then(response => {
                this.handles = response.data
            });
        }
    },
    mounted(){
        this.init();
    }
}
</script>
