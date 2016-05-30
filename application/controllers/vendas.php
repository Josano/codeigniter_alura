<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendas extends CI_Controller{

  public function nova(){
    $usuario = autoriza();

    $this->load->model(array("vendas_model", "produtos_model", "usuarios_model"));
    $venda = array(
      "produto_id" => $this->input->post("produto_id"),
      "comprador_id" => $usuario["id"],
      "data_de_entrega" =>
          dataPtBrParaMysql($this->input->post("data_de_entrega"))
    );

    $this->vendas_model->salva($venda);
    //configuracao email

    $this->load->library("email");
    $config["protocol"] = "smtp";
    $config["smtp_host"] = "ssl://smtp.gmail.com";
    $config["smtp_user"] = "onasoj@gmail.com";
    $config["smtp_pass"] = "pkx2jss2905cjl";
    $config["mailtype"] = "html";
    $config["newline"] = "\r\n";
    $config["smtp_port"] = "465";

    $this->email->initialize($config);

    $produto = $this->produtos_model->busca($venda["produto_id"]);
    $vendedor = $this->usuarios_model->busca($produto["usuario_id"]);

    $dados = array("produto" => $produto);
    $conteudo = $this->load->view("vendas/email.php", $dados, TRUE);

    //parametros do envio email
    $this->email->from("onasoj@gmail.com", "Mercado");
    $this->email->to($vendedor['email']);
    $this->email->subject("Seu produto {$produto['nome']} foi vendido!");
    $this->email->message($conteudo);
    $this->email->send();

    $this->session->set_flashdata("sucess", "Pedido de compra efetuado com sucesso");
    redirect("/");
  }

  public function index(){
    $usuario = autoriza();
    $this->load->model("produtos_model");
    $produtosVendidos = $this->produtos_model->buscaVendidos($usuario);
    $dados = array("produtosVendidos" => $produtosVendidos);
    $this->load->template("vendas/index", $dados);
  }
}
