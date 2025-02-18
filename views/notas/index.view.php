<?php $validacoes = flash()->get('validacoes'); ?>
<div class="bg-base-300 rounded-l-box w-56 flex flex-col divide-y divide-base-100">
    <?php foreach ($notas as $key => $nota): ?>
        <a href="/notas?id=<?= $nota->id ?><?= request()->get('pesquisar', '', '&pesquisar=') ?>" class="w-full p-2 cursor-pointer hover:bg-base-200
        <?php if ($key == 0): ?> rounded-tl-box <?php endif; ?>
        <?php if ($nota->id == $notaSelecionada->id): ?> bg-base-200 <?php endif; ?>">
            <?= $nota->titulo ?> <br />
            <span class="text-xs">id: <?= $nota->id ?> || criado: <?=$nota->dataCriacao()->locale('pt_BR')->diffForHumans()?></span>
        </a>
    <?php endforeach; ?>
</div>
<div class="bg-base-200 rounded-r-box w-full p-10 flex flex-col space-y-6">
    <form action="/nota" method="post" id="form-atualizacao">
        <input type="hidden" name="__method" value="PUT" />
        <input type="hidden" name="id" value="<?= $notaSelecionada->id ?>" />
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Título</span>
            </div>
            <input name="titulo" type="text" placeholder="Título" class="input input-bordered w-full" value="<?= $notaSelecionada->titulo ?>" />
            <?php if (isset($validacoes['titulo'])): ?>
                <div class="label text-xs text-error"><?= $validacoes['titulo'][0] ?></div>
            <?php endif; ?>
        </label>
        <label class="form-control">
            <div class="label">
                <span class="label-text">Sua nota</span>
            </div>
            <textarea
                <?php if (!session()->get('mostrar')): ?>
                disabled
                <?php endif; ?>
                name="nota" class="textarea textarea-bordered h-24" placeholder="Escreva aqui..."><?= $notaSelecionada->nota() ?></textarea>
            <?php if (isset($validacoes['nota'])): ?>
                <div class="label text-xs text-error"><?= $validacoes['nota'][0] ?></div>
            <?php endif; ?>
        </label>
    </form>
    <div class="flex justify-between items-center">
        <form action="/nota" method="post">
            <input type="hidden" name="__method" value="DELETE" />
            <input type="hidden" name="id" value="<?= $notaSelecionada->id ?>" />
            <button class="btn btn-error" type="submit">Deletar</button>
        </form>
        <button class="btn btn-primary" type="submit" form="form-atualizacao">Atualizar</button>
    </div>
</div>