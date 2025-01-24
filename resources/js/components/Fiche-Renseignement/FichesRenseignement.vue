<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="float-right">

                </div>
            </div>
        </div>
        <!-- Input Filtres -->
        <div class="row py-3 bg-info">
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_marque" @change="chercheTypes(filtre_marque)">
                    <option value="marque">Sélectionne une Marque</option>
                    <option :value="marque.id" v-for="marque in marques" v-if="marque !== null">{{ marque.nom }}</option>
                </select> -->
                <label>Marque</label>
                <multiselect v-model="filtre_marque" :options="this.marques" label="nom" track-by="id"
                    placeholder="Select one" @select="chercheTypes()">
                    <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom
                            }}</strong></template>
                </multiselect>
            </div>
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_type" @change="chercheMoteurs()">
                    <option value="type">Sélectionne un Type</option>
                    <option :value="type.id" v-for="type in types" v-if="type !== null">{{ type.nom }}</option>
                </select> -->
                <label>Type</label>
                <multiselect v-model="filtre_type" :options="this.types" label="nom" @select="chercheMoteurs()">
                    <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.nom }}</strong></template>
                </multiselect>
            </div>
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_moteur">
                    <option value="moteur">Sélectionne un Moteur</option>
                    <option :value="moteur.id" v-for="moteur in this.moteurs" v-if="moteur !== null">{{ moteur.nom }}</option>
                </select> -->
                <label>Moteur</label>
                <multiselect v-model="filtre_moteur" :options="this.moteurs" label="nom" @select="chercheMoteurs()">
                    <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.nom }}</strong></template>
                </multiselect>
            </div>
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_modele">
                    <option value="modèle">Sélectionne un Modèle</option>
                    <option :value="modèle.id" v-for="modèle in this.modèles" v-if="modèle !== null">{{ modèle.nom }}</option>
                </select> -->
                <label>Modèle</label>
                <multiselect v-model="filtre_modele" :options="this.modèles" label="nom" @select="chercheMoteurs()">
                    <!-- <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.nom }}</strong></template> -->
                </multiselect>
            </div>
        </div>

        <div class="row py-3 bg-info">
            <div class="col-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="" id="" value=1 v-model="filtre_archive">
                        Archivé
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="" id="" value=1 v-model="filtre_partiel">
                        Partiellement Archivé
                    </label>
                </div>
            </div>
            <div class="col-3">
                <label>Marque</label>
                <select v-model="filtre_local">
                    <option>Porto-Novo</option>
                    <option>Port-Gentil</option>
                </select>
            </div>

            <div class="col-3">
                <div class="form-check">
                    <label class="form-check-label">
                        Date From
                        <input type="date" class="form-control" name="" id="" value=1 v-model="filtre_date_from">
                    </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                    <label class="form-check-label">
                        Date To
                        <input type="date" class="form-control" name="" id="" value=1 v-model="filtre_date_to">
                    </label>
                </div>
            </div>
        </div>
        <div class="row p-3 bg-info text-center">
            <button class="btn btn-dark" @click="réinitialiser()"> <i class="fas fa-broom"></i>Réinitialiser
                Filtres</button>
        </div>
        <!-- Boutons Fonctionnalité -->
        <div class="row p-5">
            <div class="col-md-6">
                <a class="btn btn-success" href="/fiche-renseignement/renseigner"> <i class="fas fa-plus"></i> Ajouter
                    une
                    Requête</a>

                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Creer demande
                </button> -->
            </div>

            <div class="col-md-2 offset-md-4 text-right">
                <button @click="changeView('Liste')" class="btn btn-secondary" data-toggle="tooltip"
                    data-placement="top" title="Mode Liste"><i class="fas fa-bars mx-1"></i></button>
                <button @click="changeView('Carte')" class="btn btn-secondary" data-toggle="tooltip"
                    data-placement="top" title="Mode Carte"><i class="fas fa-grip-horizontal fa-1x mx-1"></i></button>
            </div>
        </div>
        <!--  -->
        <div class="row" v-if="this.viewMode === 'Liste'">
            <div class="col-md-6" id="accordion">
                <div class="card" v-for="(fiche, index) in filtered">
                    <div class="card-header " :class="fiche.color">
                        <div class="mb-0 row">
                            <div class="col-md-10 border-right" data-toggle="collapse" :data-target="'#fiche' + index">
                                Requête
                                <span v-if="fiche.marque !== null">{{ fiche.marque.nom }}</span>
                                <span v-if="fiche.type !== null"> {{ fiche.type.nom }}</span>
                                <span v-if="fiche.modèle !== null">{{ fiche.modèle.nom }}</span>
                                <span v-if="fiche.année !== null">{{ fiche.année }}</span>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="#" @click="selectionneLaModification(fiche)" data-toggle="modal"
                                    data-target="#editerRequeteModal">
                                    <i class="far fa-edit mr-3"
                                        :class="fiche.color === 'bg-danger text-white' ? 'text-white' : ''"></i>
                                </a>
                                <a href="#" @click="selectionneLaSuppression(fiche)" data-toggle="modal"
                                    data-target="#confirmerSuppressionModal">
                                    <i class="fas fa-trash-alt"
                                        :class="fiche.color === 'bg-danger text-white' ? 'text-white' : 'text-danger'"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div :id="'fiche' + index" class="collapse" data-parent="#accordion">
                        <div class="card-body">

                            <p><strong>Client:</strong> <span v-if="fiche.customer_name !== null">{{
                                fiche.marque.customer_name
                            }}</span></p>
                            <p><strong>Client:</strong> <span v-if="fiche.customer_phone !== null">{{
                                fiche.marque.customer_phone }}</span></p>
                            <p><strong>Marque:</strong> <span v-if="fiche.marque !== null">{{ fiche.marque.nom }}</span>
                            </p>
                            <p><strong>Type:</strong> <span v-if="fiche.type !== null">{{ fiche.type.nom }}</span></p>
                            <p><strong>Année:</strong> <span v-if="fiche.année !== null">{{ fiche.année }}</span></p>
                            <p><strong>Modèle:</strong> <span v-if="fiche.modèle !== null">{{ fiche.modèle.nom }}</span>
                            </p>
                            <p><strong>Moteur:</strong> <span v-if="fiche.moteur !== null">{{ fiche.moteur.nom }}</span>
                            </p>
                            <p><strong>Autre details:</strong> <span v-if="fiche.détails !== null">
                                    <a :href="fiche.détails">{{ fiche.détails }}</a>
                                </span></p>
                            <p><strong v-if="fiche.détails !== null">Articles Recherchés:</strong></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" v-for="article in fiche.articles">
                                    <!-- <input type="checkbox" @click="selectionneArticle(article)" v-if="! article.commandé"> -->
                                    <div class="row">{{ article.nom }}</div>
                                    <div class="row">{{ article.autreInfo }}</div>
                                    <div class="row">{{ article.handle.id }}</div>

                                    <!-- <button v-if="article.état === 'enregistré' " type="button" class="btn btn-primary btn-sm py-0 px-1" @click="changerEtat(index, fiche, article, 'commandé')">Commander <i class="fas fa-envelope-open-text    "></i></button> -->
                                    <span v-if="article.état === 'commandé'"
                                        class="badge badge-success badge-pill py-1">
                                        Commandé <i class="fas fa-clock"></i></span>
                                    <span v-else-if="article.état === 'demandé'"
                                        class="badge badge-warning badge-pill py-1">
                                        Demandé <i class="fas fa-sms"></i></span>
                                    <span v-else-if="article.état === 'wished'"
                                        class="badge badge-warning badge-pill py-1">
                                        Wished <i class="fas fa-clock"></i></span>

                                    <!-- <button type="button" class="btn btn-danger btn-sm py-0 px-1" @click="changerEtat(article.id, 'archivé')" >Réceptionner</button> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="this.viewMode === 'Carte'">
            <div class="card col-md-3 m-1" v-for="(fiche, index) in filtered">
                <div class="card-header" :class="fiche.color">
                    <h5 class="mb-0">
                        Requête
                        <span v-if="fiche.marque !== null">{{ fiche.marque.nom }}</span>
                        <span v-if="fiche.type !== null"> {{ fiche.type.nom }}</span>
                        <span v-if="fiche.modèle !== null">{{ fiche.modèle.nom }}</span>
                        <span v-if="fiche.année !== null">{{ fiche.année }}</span>
                        <span v-if="fiche.local !== null">{{ fiche.local }}</span>
                    </h5>
                    <div class="col-md-12">
                        <a href="#" @click="selectionneLaModification(fiche)" data-toggle="modal"
                            data-target="#editerRequeteModal">
                            <i class="far fa-edit mr-3"
                                :class="fiche.color === 'bg-danger text-white' ? 'text-white' : ''"></i>
                        </a>
                        <a href="#" @click="selectionneLaSuppression(fiche)" data-toggle="modal"
                            data-target="#confirmerSuppressionModal">
                            <i class="fas fa-trash-alt"
                                :class="fiche.color === 'bg-danger text-white' ? 'text-white' : 'text-danger'"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p v-if="fiche.marque !== null"><strong>Marque:</strong> <span>{{ fiche.marque.nom }}</span></p>
                    <p v-if="fiche.type !== null"><strong>Type:</strong><span>{{ fiche.type.nom }}</span></p>
                    <p v-if="fiche.année !== null"><strong>Année:</strong><span>{{ fiche.année }}</span></p>
                    <p v-if="fiche.modèle !== null"><strong>Modèle:</strong><span>{{ fiche.modèle.nom }}</span></p>
                    <p v-if="fiche.moteur !== null"><strong>Moteur:</strong><span>{{ fiche.moteur.nom }}</span></p>
                    <p v-if="fiche.détails !== null"><strong>Autre details:</strong> <span><a :href="fiche.détails">{{
                        fiche.détails }}</a></span></p>
                    <p><strong v-if="fiche.détails !== null">Articles Recherchés:</strong></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="article in fiche.articles">

                            <div class="row">
                                <span class="ml-1" v-if="article.handle"> {{ article.handle.name }} </span>
                                <span class="ml-1" v-else-if="article.autreGroupe"> {{ article.autreGroupe }} </span>
                                <span class="ml-1">{{ article.nom }}</span>

                                <span class="ml-1" v-if="article.autreInfo"> ( {{ article.autreInfo }} ) </span>
                            </div>
                            <div class="row"></div>
                            <div class="row star" @mouseleave="bringTheOriginalLightsBack(article)">
                                <i class="fas fa-star" :class="article.starDup >= 1 ? 'text-warning' : ''"
                                    @mouseover="lightTheStars(article, 1)" @click="storeTheStars(article, 1)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 2 ? 'text-warning' : ''"
                                    @mouseover="lightTheStars(article, 2)" @click="storeTheStars(article, 2)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 3 ? 'text-warning' : ''"
                                    @mouseover="lightTheStars(article, 3)" @click="storeTheStars(article, 3)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 4 ? 'text-warning' : ''"
                                    @mouseover="lightTheStars(article, 4)" @click="storeTheStars(article, 4)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 5 ? 'text-warning' : ''"
                                    @mouseover="lightTheStars(article, 5)" @click="storeTheStars(article, 5)"></i>
                            </div>
                            <div class="row my-2">
                                <a :href="'https://www.onlinecarparts.co.uk/spares-search.html?keyword=' + article.nom"
                                    target="_blank">OnlineCarParts</a>
                            </div>
                            <div class="row my-2">
                                <a :href="'https://www.fitinpart.sg/index.php?route=product/search/partSearch&part_no=' + article.nom + '&show=0'"
                                    target="_blank">FitinPart</a>
                            </div>
                            <div class="row my-2">
                                <a :href="'https://alvadi.ee/en/search?q=' + article.nom" target="_blank">ALVADI</a>
                            </div>
                            <div class="row" v-if="!article.editing">
                                <!-- <button v-if="article.état === 'enregistré' " type="button" class="btn btn-primary btn-sm py-0 px-1" @click="changerEtat(index, fiche, article, 'commandé')">Commander <i class="fas fa-envelope-open-text    "></i></button> -->
                                <span v-if="article.état === 'enregistré'"
                                    class="badge badge-primary badge-pill py-1">Enregistré<i
                                        class="fas fa-save"></i></span>
                                <span v-if="article.état === 'commandé'"
                                    class="badge badge-success badge-pill py-1">Commandé<i
                                        class="fas fa-clock"></i></span>
                                <span v-else-if="article.état === 'demandé'"
                                    class="badge badge-success badge-pill py-1">Demandé<i class="fas fa-sms"></i></span>
                                <span v-else-if="article.état === 'wished'"
                                    class="badge badge-warning badge-pill py-1">Wished<i
                                        class="fas fa-hand-holding"></i></span>
                                <span v-else-if="article.état === 'transit'"
                                    class="badge badge-warning badge-pill py-1">En
                                    Transit<i class="fas fa-ship"></i></span>
                                <span v-else-if="article.état === 'reçu'"
                                    class="badge badge-warning badge-pill py-1">Receptionné<i
                                        class="fas fa-dolly-flatbed"></i></span>
                                <i class="fas fa-edit text-primary ml-3" @click="allowEdits(article)"></i>
                            </div>
                            <div v-else>
                                <select v-model="article.état" class="form-control form-control-sm">
                                    <option value="enregistré">Enregistré</option>
                                    <option value="wished">Wished</option>
                                    <option value="demandé">Demandé</option>
                                    <option value="commandé">Commandé</option>
                                    <option value="transit">Transit</option>
                                    <option value="reçu">Receptionné</option>
                                </select>
                                <i class="fas fa-save text-primary ml-3" @click="updateArticle(article)"></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>








        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sélectionne Demande</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6" v-for="demande in commandes">
                                <input type="checkbox" @click="selectionneDemande(demande)">
                                <label>{{ demande.nom }}</label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="commander()">Ajouter à Demande</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editerRequeteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true" @keyup.enter="supprimeLaRequete(aSupprimer)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Marque</label>

                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.marque_id"
                                @change="chercheTypesEdit(aEditer.marque_id)">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.type_id"
                                @change="chercheMoteursEdit()">
                                <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Modèle</label>
                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.modèle_id">
                                <option :value="modèle.id" v-for="modèle in modèles" @change="chercheMoteursEdit()">{{
                                    modèle.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Moteur</label>
                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.moteur_id">
                                <option :value="moteur.id" v-for="moteur in moteurs.moteurs">{{ moteur.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Année</label>
                            <input type="text" class="form-control" v-if="aEditer" v-model="aEditer.année">
                        </div>
                        <div class="form-group">
                            <label>Numéro de Chassis</label>
                            <input type="text" class="form-control" v-if="aEditer" v-model="aEditer.chassis">
                        </div>
                        <div class="form-group">
                            <label>Autre details</label>
                            <input type="text" class="form-control" v-if="aEditer" v-model="aEditer.détails">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Ajouter Nouveaux Articles</label>

                            <div class="input-group">
                                <input type="text" class="form-control" v-if="aEditer" v-model="articleAEditer">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success text-white" type="button"
                                        @click="ajouterArticles()">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <h5 class="">Articles Recherchés
                                <a href="#" v-if="!editerArticles" @click="toggleEditArticles()">
                                    <i class="far fa-edit text-primary mx-3"></i>
                                </a>
                            </h5>
                        </div>
                    </div>
                    <ol class="list-group list-group-flush offset-md-1 col-md-6 mt-2 " v-if="aEditer">
                        <li class="list-group-item" v-if="aEditer.articles && !editerArticles"
                            v-for="(article, index) in aEditer.articles">{{ article.nom }}</li>

                        <div class="row" v-for="(article, index) in aEditer.articles">
                            <div class="col-md-10" v-if="aEditer.articles && editerArticles">
                                <input type="checkbox" v-if="aEditer"
                                    v-model="aEditer.articles[index].autreGroupeCheckBox">
                                <label for="">Autre Groupe</label>
                                <multiselect v-if="!aEditer.articles[index].autreGroupeCheckBox"
                                    v-model="aEditer.articles[index].handle" :options="handles" label="name"
                                    track-by="id" placeholder="Selectionne un Groupe">
                                    <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{
                                        option.name }}</strong></template>

                                </multiselect>
                                <input class="form-control d-inline-block" v-if="aEditer"
                                    v-model="aEditer.articles[index].nom">
                            </div>
                            <div class="col-md-2" v-if="editerArticles">
                                <button class="d-inline-block" @click="updateArticle(article)"><i
                                        class="far fa-save text-success mx-3"></i></button>
                            </div>
                        </div>
                    </ol>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateRequete()">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmerSuppressionModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true" @keyup.enter="supprimeLaRequete(aSupprimer)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Êtes-Vous sûr de vouloir supprimer cette requête. Cette action est irréversible.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"
                            @click="supprimeLaRequete(aSupprimer)">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="succèsSuppression" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                La requête a été supprimée avec succès
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect';
export default {
    props: ['fiches_prop'],
    data() {
        return {
            fiche_renseignement: {
                marque: '',
                type: '',
                année: '',
                chassis: '',
                moteur: '',
                autres: '',
                article: '',
                modèle: '',
                autreGroupe: '',
                articles: [],
                types: [],
                marques: [],
                moteurs: [],
                modèles: []
            },
            filtre_marque: 'marque',
            filtre_type: 'type',
            filtre_moteur: 'moteur',
            filtre_modele: 'modèle',
            filtre_archive: false,
            filtre_partiel: false,
            filtre_date_from: null,
            filtre_date_to: null,
            filtre_local: null,
            filtre: {
                marque: '',
                type: ''
            },
            fiches: [],
            marques: [],
            types: [],
            types_moteurs: [],
            moteurs: [],
            filtered: [],
            filtered_moteurs: [],
            modèles: [],
            selectionArticles: [],
            demandes: [],
            selectionDemandes: [],
            commandes: [],
            viewMode: 'Carte',
            aSupprimer: null,
            aEditer: null,
            handles: null,
            articleAEditer: null,
            editerArticles: false
        }
    },
    methods: {
        allowEdits(article) {
            article.editing = !article.editing
            this.$forceUpdate()
        },
        chercheTypes() {
            setTimeout(() => {
                console.log('The id is ' + this.filtre_marque.id)
                axios.get('/fiche-renseignement/type/de-marque/' + this.filtre_marque.id).then(response => {
                    this.types = response.data;
                    console.log(response.data);
                }).catch(error => {
                    console.log(error);
                });
            }, 100);

        },
        chercheMoteurs() {
            setTimeout(() => {
                axios.get('/fiche-renseignement/moteur/de-type/' + this.filtre_type.id).then(response => {
                    console.log('Moteur Time ' + this.filtre_type.id)
                    console.log(response.data)
                    this.moteurs = response.data.moteurs
                    // this.filtre_moteur = response.data.moteurs
                }).catch(error => {
                    console.log(error);
                });
            }, 1000);

            // setTimeout(() => {
            //     this.chercheModèles();
            // }, 3000);
        },
        chercheModèles() {
            axios.get('/fiche-renseignement/modèle/de-type/' + this.filtre_modèle).then(response => {
                this.filtre_modele = this.modèles = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        chercheTypesEdit(marque) {
            axios.get('/fiche-renseignement/type/de-marque/' + marque).then(response => {
                this.types = response.data;
                console.log(response.data);
                this.$forceUpdate();
            }).catch(error => {
                console.log(error);
            });
        },
        chercheMoteursEdit() {
            axios.get('/fiche-renseignement/moteur/de-type/' + this.aEditer.type_id).then(response => {
                this.moteurs.moteurs = response.data.moteurs;
            }).catch(error => {
                console.log(error);
            });
            this.chercheModèlesEdit();
        },
        chercheModèlesEdit() {
            axios.get('/fiche-renseignement/modèle/de-type/' + this.aEditer.type_id).then(response => {
                this.modèles = response.data.modèles;
            }).catch(error => {
                console.log(error);
            });
        },
        réinitialiser() {
            this.filtered = this.fiches
            this.filtre_marque = 'marque'
            this.filtre_type = 'type'
            this.filtre_moteur = 'moteur'
            this.filtre_modele = 'modèle'
            this.filtered_moteurs = this.moteurs.moteurs
            this.filtre_date_from = null
            this.filtre_date_to = null,
                this.filtre_local = null
        },
        selectionneArticle(article) {
            this.selectionArticles.push(article)
        },
        selectionneDemande(demande) {
            this.selectionDemandes.push(demande)
        },
        commander() {
            axios.post('/commande/api/commander', { commandes: this.selectionDemandes, articles: this.selectionArticles }).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        changerEtat(index, fiche, article, etat) {
            axios.post('/fiche-renseignement/api/articles/changer-etat/' + article.id, { 'etat': etat }).then(response => {
                console.log(response.data);
                article.état = etat;
                fiche.color = this.ficheColor(fiche)
                this.filtered.splice(index, 1)
                // window.location.reload()
                this.$forceUpdate()
            }).catch(error => {
                console.log(error);
            });
        },
        changeView(mode) {
            this.viewMode = mode;
        },
        selectionneLaSuppression(fiche) {
            this.aSupprimer = fiche
        },
        selectionneLaModification(fiche) {
            this.aEditer = fiche
        },
        supprimeLaRequete(fiche) {
            axios.get('fiche-renseignement/api/supprimer/' + fiche.id)
                .then(response => {
                    console.log(response.data);
                    $('#confirmerSuppressionModal').modal('hide')
                    $('#succèsSuppression').modal('show')
                    setTimeout(function () {
                        $('#succèsSuppression').modal('hide')

                    }, 2000);
                    this.init();
                }).catch(error => {
                    console.log(error);
                });

        },
        toggleEditArticles() {
            this.editerArticles = !this.editerArticles;
        },
        removeArchived() {
            this.filtered = this.fiches.filter(each => {
                return this.ficheColor(each) !== 'bg-success'
            });
        },
        init() {
            if (!this.fiches_prop) {
                axios.get('fiche-renseignement/api/all').then(response => {
                    this.fiches = this.filtered = response.data
                    this.removeArchived()
                });
                axios.get('fiche-renseignement/marque/api/all').then(response => {
                    this.marques = response.data;
                });
                axios.get('fiche-renseignement/type/api/all').then(response => {
                    this.types = response.data;
                });
                axios.get('fiche-renseignement/moteur/api/all').then(response => {
                    this.filtered_moteurs = this.moteurs.moteurs = response.data;
                });
                axios.get('fiche-renseignement/modèle/api/all').then(response => {
                    this.modèles = response.data;
                });
                axios.get('demande-achat/api/all').then(response => {
                    this.demandes = response.data;
                });
                axios.get('commande/api/all').then(response => {
                    this.commandes = response.data;
                });
                axios.get('/fiche-renseignement/moteur/api/all').then(response => {
                    this.moteurs = response.data;
                });
                axios.get('/api/handles').then(response => {
                    this.handles = response.data
                });
            }


        },
        updateRequete() {
            axios.post('/fiche-renseignement/api/update', this.aEditer).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        ajouterArticles() {
            if (this.aEditer && this.articleAEditer) {
                this.aEditer.articles.push({ nom: this.articleAEditer })
                this.$forceUpdate()
            }
        },
        updateArticle(article) {
            axios.put('/article', article).then(response => {
                console.log(response.data);
                article.editing = false
                this.$forceUpdate()
            }).catch(error => {
                console.log(error);
            });
        },
        test() {
            setTimeout(() => {
                console.log(this.filtre_marque.nom)
            }, 10);

        },
        ficheColor(fiche) {
            var nombreCommandé = 0;
            var nombreArchivé = 0;
            var nombreEnregistré = 0;
            fiche.articles.forEach((article) => {
                if (article.état === 'commandé') {
                    nombreCommandé += 1
                } else if (article.état === 'archivé') {
                    nombreArchivé += 1
                } else if (article.état === 'enregistré') {
                    nombreEnregistré += 1
                }
            })
            if (nombreCommandé === fiche.articles.length) {
                return 'bg-success'
            } else if (nombreCommandé > 0 && nombreCommandé < fiche.articles.length) {
                return 'bg-danger text-white'
            } else if (nombreCommandé === fiche.articles.length) {
                return 'bg-success'
            }
        },
        lightTheStars(article, number) {
            article.starDup = number
            this.$forceUpdate()
        },
        storeTheStars(article, number) {
            axios.post('/fiche-renseignement/api/articles/' + article.id + '/store-the-stars', { stars: number }).then(response => {
                console.log(response.data);
                article.starDup = number
                article.star = number
                this.$forceUpdate()
            }).catch(error => {
                console.log(error);
            });

        },
        bringTheOriginalLightsBack(article) {
            article.starDup = article.star
            this.$forceUpdate()
        }
    },
    watch: {
        filtre_marque() {
            console.log('I changed')
            if (this.filtre_marque !== 'marque') {
                this.filtered = this.fiches.filter((each) => {
                    return each.marque_id === this.filtre_marque.id
                });
                this.filtered_moteurs = this.moteurs.filter((each) => {
                    return each.marque_id === this.filtre_marque.id
                });
            } else {
                axios.get('fiche-renseignement/marque/api/all').then(response => {
                    this.marques = response.data;
                });
            }
        },
        filtre_type() {
            console.log('I changed too')
            if (this.filtre_type !== 'type') {
                this.filtered = this.fiches.filter((each) => {
                    return each.type_id === this.filtre_type.id
                })
            } else {
                axios.get('fiche-renseignement/type/api/all').then(response => {
                    this.types = response.data;
                });
            }

        },
        filtre_moteur() {
            if (this.filtre_moteur !== 'moteur') {
                this.filtered = this.fiches.filter((each) => {
                    return each.moteur_id === this.filtre_moteur.id
                })
            } else {
                axios.get('fiche-renseignement/moteur/api/all').then(response => {
                    this.filtered_moteurs = this.moteurs.moteurs = response.data;
                });
            }
        },
        filtre_modele() {
            if (this.filtre_modele !== 'modèle') {
                this.filtered = this.fiches.filter((each) => {
                    return each.modèle_id === this.filtre_modele.id
                })
            }
        },
        filtre_archive() {
            if (this.filtre_archive === true) {
                this.filtered = this.fiches.filter((each) => {
                    return this.ficheColor(each) === 'bg-success'
                })
            } else {
                this.filtered = this.fiches.filter((each) => {
                    return this.ficheColor(each) !== 'bg-success'
                })

            }
        },
        filtre_partiel() {
            if (this.filtre_partiel === true) {
                this.filtered = this.fiches.filter((each) => {
                    return this.ficheColor(each) === 'bg-danger text-white'
                })
            } else {
                this.filtered = this.fiches.filter((each) => {
                    return (this.ficheColor(each) !== 'bg-danger text-white')
                })
                this.filtered = this.filtered.filter((each) => {
                    return this.ficheColor(each) !== 'bg-success'
                })
            }
        },
        filtre_date_from() {
            this.filtered = this.fiches.filter(element => {
                if (this.filtre_date_to === null) {
                    return Date.parse(element.created_at.replace('-', '/', 'g')) > Date.parse(this.filtre_date_from)
                } else {
                    return Date.parse(element.created_at.replace('-', '/', 'g')) > Date.parse(this.filtre_date_from) && Date.parse(element.created_at.replace('-', '/', 'g')) < Date.parse(this.filtre_date_to)
                }
            });
        },
        filtre_date_to() {
            this.filtered = this.fiches.filter(element => {
                if (this.filtre_date_from === null) {
                    return Date.parse(element.created_at.replace('-', '/', 'g')) < Date.parse(this.filtre_date_to)
                } else {
                    return Date.parse(element.created_at.replace('-', '/', 'g')) > Date.parse(this.filtre_date_from) && Date.parse(element.created_at.replace('-', '/', 'g')) < Date.parse(this.filtre_date_to)
                }
            });
        },
        filtre_local() {
            this.filtered = this.fiches.filter(element => {
                return element.local === this.filtre_local

            });
        }
    },
    computed: {

    },
    mounted() {
        this.init();
        setTimeout(() => {
            this.fiches.forEach((fiche) => {
                // console.log(fiche.id)
                fiche.color = this.ficheColor(fiche)
                fiche.articles.forEach(article => {
                    // article.star = Math.floor(Math.random() * 4) + 1
                    article.starDup = article.stars
                    article.editing = false;
                })

            });
            this.$forceUpdate()
        }, 3000);

    },
    created() {

    }
}
</script>

<style>
.form-control {
    display: inline-block;
}

.star:hover {
    cursor: pointer;
}
</style>
