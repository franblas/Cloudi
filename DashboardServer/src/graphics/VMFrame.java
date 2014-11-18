package graphics;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.util.ArrayList;

import javax.swing.JButton;
import javax.swing.JEditorPane;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;
import javax.swing.JTextField;

import server.Stats;
import utils.BashUtils;

import com.mysql.jdbc.Connection;

import database.db;

/**
 * 
 * @author Paco
 *
 */
public class VMFrame extends JFrame implements ActionListener{

	/**
	Les panneaux
	**/
	private JPanel pan = new JPanel(); //Panneau principal
	private JPanel pan1 = new JPanel();
	private JPanel pan2 = new JPanel();
	
	/**
	 * Les boutons
	 */
	private JButton bouton_infovm= new JButton(); //bouton 
	
	/**
	 * Les Labels
	 */
	private JLabel label_username = new JLabel("Nom utilisateur",JLabel.CENTER);
	private JLabel label_nomvm = new JLabel("Nom VM",JLabel.CENTER);
	
	/**
	 * les champs texte
	 */
	private JTextField text_username = new JTextField();
	private JTextField text_nomvm = new JTextField();
	
	/**
	 * Useful
	 */
	private Connection co = null;
	
	/**
	 * 
	 * @param nom
	 * @param largeur
	 * @param hauteur
	 * @param conn
	 * @param sudopass
	 */
	public VMFrame(String nom,int largeur, int hauteur, Connection conn, String sudopass){
		this.co = conn;
		
		//Frame options
		this.setTitle(nom); //Titre de la Fenetre
		this.setSize(largeur,hauteur); //taille de la fen�tre en pixels
		this.setBackground(Color.WHITE); //Fond de la fen�tre
		this.setLocationRelativeTo(null); //Positionnement au centre
		this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE); //Termine le processus lorsqu'on clique sur la croix rouge
		this.setResizable(false); //Empeche/Autorise redimensionnement
		this.setAlwaysOnTop(false); //Toujours/Jamais au 1er plan
		
		//bouton config
		bouton_infovm.setText("Infos VM");
		bouton_infovm.setToolTipText("Obtenir des infos sur la VM");
		
		bouton_infovm.addActionListener(this);
		
		this.getRootPane().setDefaultButton(bouton_infovm);
		
		//layout config
		GridLayout gridpan1 = new GridLayout(0,1);
		GridLayout gridpan2 = new GridLayout(0,2);
		pan.setLayout(gridpan2);
		pan1.setLayout(gridpan2);
		pan2.setLayout(gridpan1);

		//add components to panels
		pan1.add(label_username);
		pan1.add(text_username);
		pan1.add(label_nomvm);
		pan1.add(text_nomvm);
		pan1.add(bouton_infovm);

		ArrayList<String> userlist = new db().userBDDList(conn);
		String toto = "<html><body>";
		for(int k=0;k<userlist.size();k++){
		//System.out.println(userlist[k]);
		toto += "<span style='font-size:14px;'>"+userlist.get(k)+"</span><br/>"+new BashUtils().outputCommand("ls /home/"+userlist.get(k)+"/VirtualBox\\ VMs/",""+sudopass)+"<br/><br/>";
		}
		toto+="</body></html>";
		JEditorPane textarea = new JEditorPane("text/html",toto);
		JScrollPane scrollpane = new JScrollPane(textarea); //utilisation d'un panneau scrollé pour des longs fichiers
		scrollpane.setPreferredSize(new Dimension(300,200));
		//boite_dialogue.showMessageDialog(null,scrollpane,"VMs par utilisateur",JOptionPane.INFORMATION_MESSAGE);
		pan2.add(scrollpane);
		pan.add(pan2);
		pan.add(pan1);
		
		this.getContentPane().add(new JScrollPane(pan),BorderLayout.CENTER);

		this.setVisible(true);	
	}

	@Override
	public void actionPerformed(ActionEvent arg0) {
		if(arg0.getSource() == bouton_infovm){
			if(text_username.getText()!=null && text_nomvm.getText()!=null){
				new Stats(co).affichevminfo(text_username.getText(),text_nomvm.getText());
			}
			else{
				System.out.println("Error !");
				JOptionPane.showMessageDialog(null,"Veuillez remplir tout les champs !","Erreur",JOptionPane.INFORMATION_MESSAGE);
			}
		}
	}

}//end of class
