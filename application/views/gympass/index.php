<div class="app-content content center-layout">
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12">
                <div class="card card-vista-titulos ">
                    <h3 class="text-white"><strong><?php echo $pagina_titulo; ?></strong></h3>
                </div>
            </div>
        </div>

        <div class="content-header row px-1 my-1">

            <div class="content-header-left col-md-6 col-12">

                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('inicio'); ?>">Inicio</a></li>
                            <li class="breadcrumb-item active"><?php echo $pagina_titulo; ?></li>
                        </ol>
                    </div>
                </div>

            </div>

            <div class="content-header-right col-md-6 col-12">
            </div>
        </div>

        <div class="content-body">
            <section id="section">

                <?php $this->load->view('_templates/mensajes_alerta.tpl.php'); ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card no-border">

                            <div class="card-header">
                                <h4 class="card-title"><?php echo $pagina_subtitulo; ?></h4>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <p><?php echo "<pre>" . json_encode($create_slot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>"; ?></p>

                                            <?php $array = json_decode('{"metadata":{"total":1,"errors":0},"results":[{"id":48545,"class_id":1713,"occur_date":"2024-06-07T08:10:00Z","status":1,"room":"Virtual test","length_in_minutes":60,"total_capacity":20,"total_booked":0,"product_id":119,"booking_window":{"opens_at":"2024-06-01T12:59:59Z","closes_at":"2024-06-07T07:10:00Z"},"cancellable_until":"2024-06-07T04:10:00Z","instructors":[{"name":"Freddy","substitute":false}],"virtual":false}]}'); ?>
                                            <p><?php echo "<pre>" . json_encode($array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>"; ?></p>
                                            <?php $array_results = $array->results[0]; ?>
                                            <p><?php print_r($array_results->id); ?></p>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <p><?php echo "<pre>" . json_encode($list_slots, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>"; ?></p>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <h3>Classes</h3>
                                            <!-- <p><?php echo "<pre>" . json_encode($list_classes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>"; ?></p> -->
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>name</th>
                                                        <th>slug</th>
                                                        <th>description</th>
                                                        <th>notes</th>
                                                        <th>bookable</th>
                                                        <th>visible</th>
                                                        <th>product_id</th>
                                                        <th>gym_id</th>
                                                        <th>created_at</th>
                                                        <th>system_id</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($list_classes['classes'] as $product) : ?>
                                                        <tr>
                                                            <td><?php echo $product['id']; ?></td>
                                                            <td><?php echo $product['name']; ?></td>
                                                            <td><?php echo $product['slug']; ?></td>
                                                            <td><?php echo $product['description']; ?></td>
                                                            <td><?php echo $product['notes']; ?></td>
                                                            <td><?php echo $product['bookable']; ?></td>
                                                            <td><?php echo $product['visible']; ?></td>
                                                            <td><?php echo $product['product_id']; ?></td>
                                                            <td><?php echo $product['gym_id']; ?></td>
                                                            <td><?php echo $product['created_at']; ?></td>
                                                            <td><?php echo $product['system_id']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <h3>Products</h3>
                                            <!-- <p><?php echo "<pre>" . json_encode($list_products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>"; ?></p> -->
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>product_id</th>
                                                        <th>name</th>
                                                        <th>updated_at</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($list_products['products'] as $product) : ?>
                                                        <tr>
                                                            <td><?php echo $product['product_id']; ?></td>
                                                            <td><?php echo $product['name']; ?></td>
                                                            <td><?php echo $product['updated_at']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>
        </div>

    </div>
</div>