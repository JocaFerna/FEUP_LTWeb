<nav class="side-bar">
            <ul>
                <li>Filters
                    <ul id="filters">
                        <li>
                            <lable for="size">Size</lable>
                            <select name="size" id="size">
                                <option value =""></option>
                                <?php
                                    $database = new PDO('sqlite:' . __DIR__ . '/database/LTW.db');
                                    $size = $database->prepare('SELECT Size.name as namee
                                    FROM Size');
                                    $size->execute();
                                    $tamanho = $size->fetchAll();
                                    foreach($tamanho as $tam){
                                        ?><option value=<?php echo $tam['namee'];?>><?php echo $tam['namee'];?></option>
                                        <?php
                                    }
                                ?>   
                            </select>
                        </li> 
                        <li>
                            <label for="conditions">Condition</label>
                            <select name="conditions" id="conditions">
                                <option value =""></option>
                                <?php
                                    $condicoes = $database->prepare('SELECT Condition.name as name
                                    FROM Condition');
                                    $condicoes->execute();
                                    $conditions = $condicoes->fetchAll();
                                    foreach($conditions as $condicao){
                                        ?><option value=<?php echo $condicao['name'];?>><?php echo $condicao['name'];?></option>
                                        <?php
                                    }
                                ?>  
                            </select>
                        </li>
                        <li>Price
                            <input id="lower-price" name="min-price" type="numbers" step="0.01" min="0" placeholder="min">
                            <div class="separator">-</div>
                            <input id="higher-price" name="max-price" type="numbers" step="0.01" min="0" placeholder="max">
                        </li>
                        <div class="check" id="avail">
                            <label for="isAvail"> Not Available: </label>
                            <input type="checkbox" style="width:auto;" id="availability" name="isAvail" value="Available">
                        </div>
                        <li>
                            <label for="date">Posting Date: </label>
                            <input type="date" id="date" name="date" min="2024-01-01">
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        </form>