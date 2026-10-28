<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Formulaire de Saisie Globale</h3>
    </div>
    
    <form action="{{ admin_url('evaluations/saisie-globale') }}" method="POST" class="form-horizontal">
        @csrf

        <div class="box-body">
            <!-- 1. Choix de la Classe / Affectation -->
            <div class="form-group">
                <label class="col-sm-2 control-label">Classe & Matière <span class="text-red">*</span></label>
                <div class="col-sm-8">
                    <select name="affectations_id" id="affectations_id" class="form-control select2" required {{ $selectedClassId ? 'readonly' : '' }}>
                        <option value="">-- Sélectionner une classe --</option>
                        @foreach($affectations as $aff)
                            <option value="{{ $aff->id_affectations }}" {{ $selectedClassId == $aff->classes_id ? 'selected' : '' }}>
                                {{ optional($aff->classes)->nom_classe }} ➔ {{ optional($aff->matieres)->nom_matiere }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 2. Informations générales de l'évaluation -->
            <div class="form-group">
                <label class="col-sm-2 control-label">Intitulé (ex: Devoir 1) <span class="text-red">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="nom_evaluation" class="form-control" required placeholder="Ex: Interrogation écrite N°1">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Type d'évaluation <span class="text-red">*</span></label>
                <div class="col-sm-8">
                    <select name="type_evaluation" class="form-control" required>
                        <option value="Interrogation">Interrogation</option>
                        <option value="Devoir">Devoir</option>
                        <option value="Examen">Examen</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Date & Durée</label>
                <div class="col-sm-4">
                    <input type="datetime-local" name="date_evaluation" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                </div>
                <div class="col-sm-4">
                    <input type="text" name="duree" class="form-control" placeholder="Durée (ex: 1h)">
                </div>
            </div>

            <hr>
            <h4>Attribution des notes par groupes d'élèves</h4>
            <p class="text-muted">Sélectionnez les élèves concernés par une note, puis ajoutez un groupe si un autre groupe d'élèves a une note différente.</p>

            <!-- Conteneur dynamique des blocs de notes -->
            <div id="groupes-container">
                <!-- Un bloc par défaut -->
                <div class="panel panel-default groupe-block" style="padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                    <div class="row">
                        <div class="col-sm-4">
                            <label>Note attribuée (/20) <span class="text-red">*</span></label>
                            <input type="number" step="0.25" min="0" max="20" name="notes_groupes[0][note]" class="form-control" placeholder="Ex: 14.5" required>
                        </div>
                        <div class="col-sm-7">
                            <label>Élèves concernés <span class="text-red">*</span></label>
                            <select name="notes_groupes[0][eleve_ids][]" class="form-control select2-eleves" multiple required style="width: 100%;">
                                <!-- Rempli dynamiquement via JS selon la classe choisie -->
                            </select>
                        </div>
                        <div class="col-sm-1" style="padding-top: 25px;">
                            <button type="button" class="btn btn-danger btn-sm btn-supprimer-groupe" style="display:none;"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="btn-ajouter-groupe" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Ajouter un autre groupe de note</button>

            <hr>
            <div class="form-group">
                <label class="col-sm-2 control-label">Observations</label>
                <div class="col-sm-8">
                    <textarea name="observations" class="form-control" rows="2"></textarea>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Enregistrer toutes les notes</button>
        </div>
    </form>
</div>

<!-- Script JavaScript pour dynamiser les élèves et l'ajout de groupes -->
<script>
    var classesDonnees = @json($classesAvecEleves);
    var groupeIndex = 0;

    // Fonction pour charger les élèves de la classe sélectionnée
    function chargerEleves(affectationId, selectElement) {
        selectElement.innerHTML = '';
        if (affectationId && classesDonnees[affectationId]) {
            var eleves = classesDonnees[affectationId].eleves;
            eleves.forEach(function(eleve) {
                var opt = document.createElement('option');
                opt.value = eleve.id;
                opt.textContent = eleve.nom + ' (Mat: ' + eleve.matricule + ')';
                selectElement.appendChild(opt);
            });
        }
        $(selectElement).trigger('change');
    }

    document.getElementById('affectations_id').addEventListener('change', function() {
        var affectationId = this.value;
        var elevesSelects = document.querySelectorAll('.select2-eleves');

        elevesSelects.forEach(function(select) {
            chargerEleves(affectationId, select);
        });
    });

    document.getElementById('btn-ajouter-groupe').addEventListener('click', function() {
        groupeIndex++;
        var container = document.getElementById('groupes-container');
        var premierBloc = container.querySelector('.groupe-block');
        
        // Détruire select2 sur le bloc cloné avant de cloner pour éviter les bugs d'affichage
        var oldSelect = premierBloc.querySelector('.select2-eleves');
        if ($(oldSelect).hasClass('select2-hidden-accessible')) {$(oldSelect).select2('destroy');
        }

        var nouveauBloc = premierBloc.cloneNode(true);

        // Réinitialiser select2 sur l'ancien bloc
        $(oldSelect).select2();

        // Mettre à jour les noms des inputs du nouveau bloc
        nouveauBloc.querySelector('input[type="number"]').name = `notes_groupes[${groupeIndex}][note]`;
        nouveauBloc.querySelector('input[type="number"]').value = '';
        
        var selectEleves = nouveauBloc.querySelector('select');
        selectEleves.name = `notes_groupes[${groupeIndex}][eleve_ids][]`;
        selectEleves.innerHTML = ''; // Vider

        // Remplir le select du nouveau bloc si une classe est déjà choisie
        var affectationId = document.getElementById('affectations_id').value;
        if (affectationId) {
            chargerEleves(affectationId, selectEleves);
        }

        // Afficher le bouton supprimer
        nouveauBloc.querySelector('.btn-supprimer-groupe').style.display = 'block';
        nouveauBloc.querySelector('.btn-supprimer-groupe').addEventListener('click', function() {
            nouveauBloc.remove();
        });

        container.appendChild(nouveauBloc);
        $(nouveauBloc.querySelector('.select2-eleves')).select2();
    });

    $(document).ready(function() {
        $('.select2').select2();$('.select2-eleves').select2();

        // Si une classe est déjà pré-sélectionnée (via le bouton de la grille), charger ses élèves immédiatement
        var affectationSelect = document.getElementById('affectations_id');
        if (affectationSelect && affectationSelect.value) {
            var event = new Event('change');
            affectationSelect.dispatchEvent(event);
        }
    });
</script>