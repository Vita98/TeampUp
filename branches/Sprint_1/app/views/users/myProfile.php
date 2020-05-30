<?php require APPROOT . '/views/inc/header.php'; ?>

    <div class="row">
        <div class="container bg-light rounded mt-5 col-md-10">
            <div class="container text-center">
                <label class="display-3 ">Il Mio Profilo</label>
            </div>

            <div class="form-group mt-3">
                <label for="firstName" class="display-5 font-weight-bolder">Nome: </label>
                <label for="firstName"><?php if (isset($data['userDTO'])) echo ($data['userDTO']->getFirstName());?></label>
            </div>
            <div class="form-group mt-3">
                <label for="firstName" class="display-5 font-weight-bolder">Cognome: </label>
                <label for="firstName"><?php if (isset($data['userDTO'])) echo ($data['userDTO']->getLastName());?></label>
            </div>
            <div class="form-group mt-3">
                <label for="firstName" class="display-5 font-weight-bolder">Email: </label>
                <label for="firstName"><?php if (isset($data['userDTO'])) echo ($data['userDTO']->getEmail());?></label>
            </div>
            <div class="form-group mt-3">
                <label for="firstName" class="display-5 font-weight-bolder">Lista Abilità: </label>

                <?php if (isset($data['userAbilities'])) : foreach($data['userAbilities'] as $userAbility): ?>
                    <kbd><label for="description"><?php echo($userAbility->getDescription()) ?></label></kbd>
                <?php endforeach; ?>
                <?php else : ?>
                    <label>L'utente non ha abilità associate!</label>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>