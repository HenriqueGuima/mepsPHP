<?php
    include("../config.php");

    $historia = $_POST['historia'];
    $result = $pdo->prepare("SELECT * FROM historia WHERE id_historia = :historia");
    $result->execute(array('historia' => $historia));
    $row = $result->fetch();
?>

<div class="modal-dialog">
    <div class="modal-header">
        <h5 class="modal-title">Editar Data - <?= $row['ano'];?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" name="historia" value="<?= $historia;?>">
            <div class="col-md-12">
                <div id="mensagem-editar-data"></div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label">Imagem *</label>
                    <div class="fs-upload-element fs-upload">
                        <img src="../assets/img/historia/<?= $historia;?>.jpg" alt="Imagem" width="200" id="imagem-editar-historia">
                        <div class="fs-upload-target">
                            Selecione a sua imagem em jpg.<br>
                            Dimensão: 1200px por 800px. Tamanho Máximo: 5MB.
                        </div>
                        <span class="btn btn-primary btn-file mt-15">
                            <span class="fileinput-new">Selecionar</span>
                            <input type="file" name="imagem" accept=".jpg, .jpeg" onchange="imagemEditarHistoria(this)">
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label">Ano *</label>
                    <input type="text" name="ano" class="form-control" value="<?= $row['ano'];?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label">Texto em Português *</label>
                    <textarea name="texto_pt" class="form-control" rows="4"><?= $row['texto_pt'];?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label">Texto em Inglês</label>
                    <textarea name="texto_en" class="form-control" rows="4"><?= $row['texto_en'];?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label">Texto em Espanhol</label>
                    <textarea name="texto_es" class="form-control" rows="4"><?= $row['texto_es'];?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="form-label">Texto em Francês</label>
                    <textarea name="texto_fr" class="form-control" rows="4"><?= $row['texto_fr'];?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Editar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
    </div>
</div>