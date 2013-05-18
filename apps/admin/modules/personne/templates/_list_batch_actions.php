<li class="sf_admin_batch_actions_choice">
  <select name="batch_action">
    <option value=""><?php echo __('Choisir une action', array(), 'sf_admin') ?></option>
    <option value="batchMaj"><?php echo __('Maj', array(), 'sf_admin') ?></option>
    <option value="batchDelete"><?php echo __('Supprimer', array(), 'sf_admin') ?></option>
  </select>
  <?php $form = new BaseForm(); if ($form->isCSRFProtected()): ?>
    <input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>" />
  <?php endif; ?>
  <input type="submit" value="<?php echo __('Valider', array(), 'sf_admin') ?>" />
</li>
