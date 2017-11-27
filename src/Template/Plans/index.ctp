<div class="row text-center py-5">
    <div class="col">
        <h1 class="display-4">
            <?= __('Monthly Support') ?>
        </h1>

        <p class="mb-0">
            <?= __('We require reoccurring monthly payments that help us continue to develop our Local Politics Platform.') ?>
        </p>
    </div>
</div>
<div class="row bg-light">
    <div class="col">
        <div class="container">
            <div class="row pt-4 text-center">
                <div class="col">
                    <ul class="nav nav-tabs nav-fill" id="plan-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="individuals-tab" data-toggle="tab" href="#individuals" role="tab" aria-controls="individuals" aria-expanded="true">
                                <h4 class="mb-0">
                                    <?= __('Individual Plans') ?>
                                </h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="municipalities-tab" data-toggle="tab" href="#municipalities" role="tab" aria-controls="municipalities">
                                <h4 class="mb-0">
                                    <?= __('Municipality Plans') ?>
                                </h4>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content card border-top-0 rounded-0" id="plan-tabs-content">
                        <div class="tab-pane card-body p-0 pt-3 fade show active" id="individuals" role="tabpanel" aria-labelledby="individuals-tab">
                            <p>
                                <?= __('We have plans for different types of individuals; ranging for the ordinary citizen to elected officials.') ?>
                            </p>

                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th style="font-size: 1.25rem; width: 20%" class="text-light text-uppercase text-nowrap bg-secondary"><?= __('Citizens') ?></th>
                                    <th style="font-size: 1.25rem; width: 20%" class="text-light text-uppercase text-nowrap bg-primary"><?= __('Community Contributors') ?></th>
                                    <th style="font-size: 1.25rem; width: 20%" class="text-light text-uppercase text-nowrap bg-secondary"><?= __('Candidates') ?></th>
                                    <th style="font-size: 1.25rem; width: 20%" class="text-light text-uppercase text-nowrap bg-primary"><?= __('State') ?></th>
                                    <th style="font-size: 1.25rem; width: 20%" class="text-light text-uppercase text-nowrap bg-secondary"><?= __('Congress') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="bg-light"><?= __('Personal Value Profile') ?></td>
                                    <td><?= __('Personal Value Profile') ?></td>
                                    <td class="bg-light"><?= __('Personal Value Profile') ?></td>
                                    <td><?= __('Personal Value Profile') ?></td>
                                    <td class="bg-light"><?= __('Personal Value Profile') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Personal Values Summary') ?></td>
                                    <td><?= __('Photo / Bio / Resume') ?></td>
                                    <td class="bg-light"><?= __('Photo / Bio / Resume') ?></td>
                                    <td><?= __('Photo / Bio / Resume') ?></td>
                                    <td class="bg-light"><?= __('Photo / Bio / Resume') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('General Question Submission') ?></td>
                                    <td>Citizen User Functionality</td>
                                    <td class="bg-light"><?= __('Value Matching to Users') ?></td>
                                    <td><?= __('Value Matching to Users') ?></td>
                                    <td class="bg-light"><?= __('Value Matching to Users') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Candidate Question Submission') ?></td>
                                    <td><?= __('Ideas (White Papers/Plans)') ?></td>
                                    <td class="bg-light"><?= __('Ideas (White Papers/Plans)') ?></td>
                                    <td><?= __('Ideas (White Papers/Plans)') ?></td>
                                    <td class="bg-light"><?= __('Ideas (White Papers/Plans)') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Value Question Sorting by Topic') ?></td>
                                    <td><?= __('Contact Info') ?></td>
                                    <td class="bg-light"><?= __('Video Submission') ?> (2)</td>
                                    <td><?= __('Video Submission') ?> (3)</td>
                                    <td class="bg-light"><?= __('Video Submission') ?> (5)</td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Receive Data Reports on Common Trends') ?></td>
                                    <td>-</td>
                                    <td class="bg-light"><?= __('Donors') ?></td>
                                    <td><?= __('Donors') ?></td>
                                    <td class="bg-light"><?= __('Donors') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light">-</td>
                                    <td>-</td>
                                    <td class="bg-light"><?= __('Contact Info') ?></td>
                                    <td><?= __('Voting Records') ?></td>
                                    <td class="bg-light"><?= __('Voting Records') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light">-</td>
                                    <td>-</td>
                                    <td class="bg-light">-</td>
                                    <td><?= __('Contact Info') ?></td>
                                    <td class="bg-light"><?= __('Contact Info') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap bg-light">
                                        <strong style="font-size: 1.25rem"><?= __('Free Forever') ?></strong>
                                    </td>
                                    <td class="text-nowrap">
                                        <strong style="font-size: 1.25rem"><?= __('Free Forever') ?></strong>
                                    </td>
                                    <td class="text-nowrap bg-light">
                                        <p>
                                            <strong style="font-size: 1.25rem"><?= __('Free Forever') ?></strong>
                                        </p>
                                        <p class="mb-0">
                                            <?= $this->Html->link(
                                                __('Choose Plan'),
                                                ['_name' => 'billing:checkout', 'plan' => 'individual_candidate'],
                                                ['class' => ['btn', 'btn-secondary']
                                            ]) ?>
                                            <br>
                                            <small class="text-muted">(<?= __('During campaign') ?>)</small>
                                        </p>
                                    </td>
                                    <td class="text-nowrap">
                                        <p>
                                            <strong style="font-size: 1.25rem">$50.00</strong> / <?= __('month') ?>
                                        </p>
                                        <p class="mb-0">
                                            <?= $this->Html->link(
                                                __('Choose Plan'),
                                                ['_name' => 'billing:checkout', 'plan' => 'individual_state'],
                                                ['class' => ['btn', 'btn-secondary']
                                            ]) ?>
                                        </p>
                                    </td>
                                    <td class="text-nowrap bg-light">
                                        <p>
                                            <strong style="font-size: 1.25rem">$50.00</strong> / <?= __('month') ?>
                                        </p>
                                        <p class="mb-0">
                                            <?= $this->Html->link(
                                                __('Choose Plan'),
                                                ['_name' => 'billing:checkout', 'plan' => 'individual_congress'],
                                                ['class' => ['btn', 'btn-secondary']
                                            ]) ?>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane card-body p-0 pt-3 fade" id="municipalities" role="tabpanel" aria-labelledby="municipalities-tab">
                            <p>
                                <?= __('Municipality profiles are for entire electoral districts, such as districts, towns and counties.') ?>
                            </p>

                            <table class="table mb-0">
                                <thead>
                                <tr>
                                    <th style="font-size: 1.25rem; width: 25%" class="text-light text-uppercase text-nowrap bg-secondary"><?= __('School Districts') ?></th>
                                    <th style="font-size: 1.25rem; width: 25%" class="text-light text-uppercase text-nowrap bg-primary"><?= __('Special Districts') ?></th>
                                    <th style="font-size: 1.25rem; width: 25%" class="text-light text-uppercase text-nowrap bg-secondary"><?= __('Towns') ?></th>
                                    <th style="font-size: 1.25rem; width: 25%" class="text-light text-uppercase text-nowrap bg-primary"><?= __('County') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="bg-light"><?= __('Personal Value Profile') ?></td>
                                    <td><?= __('Personal Value Profile') ?></td>
                                    <td class="bg-light"><?= __('Personal Value Profile') ?></td>
                                    <td><?= __('Personal Value Profile') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Personal Values Summary') ?></td>
                                    <td><?= __('Photo / Bio / Resume') ?></td>
                                    <td class="bg-light"><?= __('Photo / Bio / Resume') ?></td>
                                    <td><?= __('Photo / Bio / Resume') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('General Question Submission') ?></td>
                                    <td><?= __('Value Matching to Users') ?></td>
                                    <td class="bg-light"><?= __('Value Matching to Users') ?></td>
                                    <td><?= __('Value Matching to Users') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Candidate Question Submission') ?></td>
                                    <td><?= __('Ideas (White Papers/Plans)') ?></td>
                                    <td class="bg-light"><?= __('Ideas (White Papers/Plans)') ?></td>
                                    <td><?= __('Ideas (White Papers/Plans)') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Value Question Sorting by Topic') ?></td>
                                    <td><?= __('Video Submission') ?> (2)</td>
                                    <td class="bg-light"><?= __('Video Submission') ?> (3)</td>
                                    <td><?= __('Video Submission') ?> (5)</td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><?= __('Receive Data Reports on Common Trends') ?></td>
                                    <td><?= __('Donors') ?></td>
                                    <td class="bg-light"><?= __('Donors') ?></td>
                                    <td><?= __('Donors') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light">-</td>
                                    <td><?= __('Contact Info') ?></td>
                                    <td class="bg-light"><?= __('Contact Info') ?></td>
                                    <td><?= __('Voting Records') ?></td>
                                </tr>
                                <tr>
                                    <td class="bg-light">-</td>
                                    <td>-</td>
                                    <td class="bg-light">-</td>
                                    <td><?= __('Contact Info') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap bg-light">
                                        <p>
                                            <strong style="font-size: 1.25rem">$10.00</strong> / <?= __('month') ?>
                                        </p>
                                        <p class="mb-0">
                                            <?= $this->Html->link(
                                                __('Choose Plan'),
                                                ['_name' => 'billing:checkout', 'plan' => 'municipality_school'],
                                                ['class' => ['btn', 'btn-secondary']
                                            ]) ?>
                                        </p>
                                    </td>
                                    <td class="text-nowrap">
                                        <p>
                                            <strong style="font-size: 1.25rem">$20.00</strong> / <?= __('month') ?>
                                        </p>
                                        <p class="mb-0">
                                            <?= $this->Html->link(
                                                __('Choose Plan'),
                                                ['_name' => 'billing:checkout', 'plan' => 'municipality_special'],
                                                ['class' => ['btn', 'btn-secondary']
                                            ]) ?>
                                        </p>
                                    </td>
                                    <td class="text-nowrap bg-light">
                                        <p>
                                            <strong style="font-size: 1.25rem">$100.00</strong> / <?= __('month') ?>
                                        </p>
                                        <p class="mb-0">
                                            <?= $this->Html->link(
                                                __('Choose Plan'),
                                                ['_name' => 'billing:checkout', 'plan' => 'municipality_town'],
                                                ['class' => ['btn', 'btn-secondary']
                                            ]) ?>
                                        </p>
                                    </td>
                                    <td class="text-nowrap">
                                        <p>
                                            <strong style="font-size: 1.25rem">$100.00</strong> / <?= __('month') ?>
                                        </p>
                                        <p class="mb-0">
                                            <?= $this->Html->link(
                                                __('Choose Plan'),
                                                ['_name' => 'billing:checkout', 'plan' => 'municipality_county'],
                                                ['class' => ['btn', 'btn-secondary']
                                            ]) ?>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
